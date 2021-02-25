<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Invoices;
use App\Models\Wallet;
use Faker\Provider\zh_CN\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Invoice as InvoiceRequest;

class AppControlController extends Controller
{

    public function home(?Request $request)
    {

        if ($request->wallet_id) {

            session()->put('wallet_id', $request->wallet_id);
            $wallet = Wallet::where('id', session('wallet_id'))->where('user_id', Auth::user()->id)->first();
            session()->put('wallet', $wallet->id);

        } elseif (session('wallet_id') == null) {

            $wallet = Wallet::where('user_id', Auth::user()->id)->where('signature', 'free')->first();
            session()->put('wallet', $wallet->id);
        }

        $incomePaid = Invoices::where('user_id', Auth::user()->id)
            ->where('wallet_id', session('wallet'))
            ->where('type', 'income')
            ->where('status', 'paid')
            ->sum('value');

        $expensePaid = Invoices::where('user_id', Auth::user()->id)
            ->where('wallet_id', session('wallet'))
            ->where('type', 'expense')
            ->where('status', 'paid')
            ->sum('value');

        $expenseUnpaid = Invoices::where('user_id', Auth::user()->id)
            ->where('wallet_id', session('wallet'))
            ->where('type', 'expense')
            ->where('status', 'unpaid')
            ->sum('value');

        $incomeUnpaid = Invoices::where('user_id', Auth::user()->id)
            ->where('wallet_id', session('wallet'))
            ->where('type', 'income')
            ->where('status', 'unpaid')
            ->sum('value');

        $incomeDateUnpaid = Invoices::where('user_id', Auth::user()->id)
            ->where('wallet_id', session('wallet'))
            ->where('type', 'income')
            ->where('status', 'unpaid')
            ->orderBy('due_at', 'ASC')
            ->limit(5)->get();

        $expenseDateUnpaid = Invoices::where('user_id', Auth::user()->id)
            ->where('wallet_id', session('wallet'))
            ->where('type', 'expense')
            ->where('status', 'unpaid')
            ->orderBy('due_at', 'ASC')
            ->limit(5)->get();


        return view('admin.home', [
            'income' => $incomePaid,
            'expense' => $expensePaid,
            'total' => ($incomePaid - $expensePaid),
            'expenseUnpaid' => $expenseUnpaid,
            'incomeUnpaid' => $incomeUnpaid,
            'incomeDateUnpaid' => $incomeDateUnpaid,
            'expenseDateUnpaid' => $expenseDateUnpaid
        ]);
    }

    public function launch(InvoiceRequest $request)
    {

        $invoices = new Invoices();
        $invoices->user_id = Auth::user()->id;
        $invoices->wallet_id = $request->wallet_id;
        $invoices->category_id = $request->category_id;
        $invoices->description = $request->description;
        $invoices->invoice_of = null;
        $invoices->type = ($request->repeat_when == "fixed" ? "fixed_{$request->type}" : $request->type);
        $invoices->value = $request->value;
        $invoices->currency = "BRL";
        $invoices->due_at = $request->due_at;
        $invoices->repeat_when = $request->repeat_when;
        $invoices->period = ($request->repeat_when == 'single' || $request->repeat_when == 'enrollment' ? 'month' : $request->period);
        $invoices->enrollments = $request->enrollments;
        $invoices->enrollment_of = 1;
        $status = (date($request->due_at) <= date('Y-m-d') ? 'paid' : 'unpaid');
        $invoices->status = ($request->repeat_when == "fixed" ? "paid" : $status);

        $single = $invoices->save();

        //Parceladas ver depois.
        if ($invoices->repeat_when == "enrollment") {

            $invoiceOf = $invoices->id;
            for ($enrollment = 1; $enrollment < $invoices->enrollments; $enrollment++) {


                $invoices->invoice_of = $invoiceOf;
                $invoices->type = $request->type;
                $invoices->due_at = date("Y-m-d", strtotime($request->due_at . "+{$enrollment}month"));
                $invoices->status = (date($invoices->due_at) <= date("Y-m-d") ? "paid" : "unpaid");
                $invoices->enrollment_of = $enrollment + 1;

                $createEnrollment = Invoices::create($invoices->toArray());
            }

            if ($createEnrollment) {
                $type = $request->type == 'income' ? 'income' : 'expense';
                 notify()->success('Lançamento foi cadastrado com sucesso','Tudo certo!');
                return redirect()->route('control.invoice', ['type' => $type]);
            }
        }

        //Fixas
        if ($invoices->repeat_when == 'fixed') {
            $count = 12;

            $startDate = new \DateTime($invoices->due_at);

            if ($invoices->period == 'month') {
                $interval = new \DateInterval('P1M');
                $endDate = new \DateTime("+12month");
            }

            if ($invoices->period == 'year') {
                $interval = new \DateInterval('P1Y');
                $endDate = new \DateTime("+6year");
            }

            $period = new \DatePeriod($startDate, $interval, $endDate);

            $invoice_id = $invoices->id;
            foreach ($period as $item) {
                $invoices->invoice_of = $invoice_id;
                $invoices->type = $request->type;
                $invoices->due_at = $item->format('Y-m-d');
                $invoices->status = ($item->format('Y-m-d') <= date('Y-m-d') ? 'paid' : 'unpaid');
                $invoiceFixed = Invoices::create($invoices->toArray());
            }


            if ($invoiceFixed) {
                $type = $request->type == 'income' ? 'income' : 'expense';
                notify()->success('Lançamento foi cadastrado com sucesso','Tudo certo!');
                return redirect()->route('control.invoice', ['type' => $type]);
            }
        }

        if ($single) {
            $type = $request->type == 'income' ? 'income' : 'expense';
            notify()->success('Lançamento foi cadastrado com sucesso','Tudo certo!');
            return redirect()->route('control.invoice', ['type' => $type]);
        }
    }

    /**
     * Retorna o formulario de lançamentos das receitas e despesas
     */
    public function invoice(Request $request)
    {
        if ($request->type == 'expense') {
            $categories = Category::where('type', 'expense')->get();
        }

        if ($request->type == 'income') {
            $categories = Category::where('type', 'income')->get();
        }

        $wallets = Wallet::where('user_id', Auth::user()->id)->get();

        return view('admin.invoice', [
            'type' => $request->type,
            'categories' => $categories,
            'wallets' => $wallets
        ]);
    }

    /**
     * Retorna a lista de lançamentos das receitas ou despesas
     */
    public function invoices(Request $request)
    {

        if (!empty($request->date1) && !empty($request->date2)) {

            $invoices = Invoices::where('user_id', Auth::user()->id)
                ->where('wallet_id', session('wallet'))
                ->where('type', $request->type)
                ->whereBetween('due_at', [$request->date1, $request->date2])
                ->get();
        } else {
            $invoices = Invoices::where('user_id', Auth::user()->id)
                ->where('wallet_id', session('wallet'))
                ->where('type', $request->type)
                ->whereYear('due_at', date('Y'))
                ->whereMonth('due_at', date('m'))
                ->get();
        }

        if ($invoices->count() > 0) {
            foreach ($invoices as $invoice) {
                $total[] = $invoice->id;
            }
            $sumTotal = DB::table('invoices')->where('status','!=','paid')->whereIn('id', $total)->sum('value');
        }

        return view('admin.invoices', [
            'type' => $request->type,
            'invoices' => $invoices,
            'total' => $sumTotal ?? 0
        ]);
    }

    public function invoiceEdit(Request $request)
    {
        $invoice = Invoices::find($request->id);

        if ($invoice->type == 'expense' || $invoice->type == 'fixed_expense') {
            $categories = Category::where('type', 'expense')->get();
        }

        if ($invoice->type == 'income' || $invoice->type == 'fixed_income') {
            $categories = Category::where('type', 'income')->get();
        }

        $wallets = Wallet::where('user_id', Auth::user()->id)->get();

        return view('admin.invoice', [
            'type' => $invoice->type,
            'invoice' => $invoice,
            'wallets' => $wallets,
            'categories' => $categories
        ]);
    }

    public function invoiceUpdate(InvoiceRequest $request)
    {

        $invoiceUpdate = Invoices::find($request->id);

        if ($invoiceUpdate->repeat_when == 'single') {
            $invoiceUpdate->fill($request->all());
            $invoiceUpdate->status = (date($request->due_at) <= date('Y-m-d') ? 'paid' : 'unpaid');

            if ($invoiceUpdate->save()) {
                notify()->success('Seu lançamento foi atualizado com sucesso','Tudo certo!');
                return redirect()->route('control.invoiceEdit', ['id' => $request->id]);
            }
        }

        if ($invoiceUpdate->repeat_when == 'fixed') {
            $type = ($invoiceUpdate->type == 'fixed_expense' ? 'expense' : ($invoiceUpdate->type == 'fixed_income' ? 'income' : $invoiceUpdate->type));
            $id = ($invoiceUpdate->type == 'fixed_expense' || $invoiceUpdate->type == 'fixed_income' ? $invoiceUpdate->id : $invoiceUpdate->invoice_of);

            $fixeds = Invoices::where('invoice_of', $id)
                ->where('user_id', Auth::id())
                ->where('type', $type)
                ->where('status', 'unpaid')->get();

            foreach ($fixeds as $fixed) {
                $day = $request->due_at;
                $year = date('Y', strtotime($fixed->due_at));
                $month = date('m', strtotime($fixed->due_at));

                $fixed->wallet_id = $request->wallet_id;
                $fixed->category_id = $request->category_id;
                $fixed->description = $request->description;
                $fixed->due_at = date("{$year}-{$month}-{$day}");
                $fixed->value = $request->value;
                $fixed->status = (date($fixed->due_at) <= date('Y-m-d') ? 'paid' : 'unpaid');
                $fixedUpdate = $fixed->save();
            }
            if ($fixedUpdate) {
                notify()->success('Seu lançamento foi atualizado com sucesso','Tudo certo!');
                return redirect()->route('control.invoiceEdit', ['id' => $request->id]);
            }
        }

        if ($invoiceUpdate->repeat_when == 'enrollment') {

            $enrollment = Invoices::find($request->id);

            $day = $request->due_at;
            $year = date('Y', strtotime($enrollment->due_at));
            $month = date('m', strtotime($enrollment->due_at));

            $enrollment->fill($request->all());
            $enrollment->due_at = date("{$year}-{$month}-{$day}");

            if ($enrollment->save()) {
                notify()->success('Seu lançamento foi atualizado com sucesso','Tudo certo!');
                return redirect()->route('control.invoiceEdit', ['id' => $request->id]);
            }
        }
    }

    /**
     * Retorna a lista de lançamentos das receitas ou despesas fixas (espelhos)
     */
    public function fixed(Request $request)
    {
        $invoiceFixed = Invoices::where('user_id', Auth::user()->id)
            ->where('wallet_id', session('wallet'))
            ->whereIn('type', ['fixed_income', 'fixed_expense'])
            ->get();

        return view('admin.fixed', [
            'fixes' => $invoiceFixed
        ]);
    }

    public function status(Request $request)
    {
        $onpaid = Invoices::find($request->id);

        if($onpaid->status == 'unpaid'){
            $onpaid->status = 'paid';
            $onpaid->save();
            $json['status'] = $onpaid->status;
            $json['id'] = $onpaid->id;
        }else {
            $onpaid->status = 'unpaid';
            $onpaid->save();
            $json['status'] = $onpaid->status;
            $json['id'] = $onpaid->id;
        }

        return response()->json($json);
    }
}
