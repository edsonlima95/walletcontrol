<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::user()->id)->get();

        return view('admin.wallet.index', [
            'wallets' => $wallets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->premium === 0) {
            notify()->error('Desculpe, apenas o plano premium pode criar novas carteiras', 'Plano Grátis');
            return redirect()->route('control.wallets.index');
        }

        return view('admin.wallet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required'
        ]);

        $credentials['user_id'] = $request->user_id;
        $credentials['signature'] = 'premium';

        if (Wallet::create($credentials)) {
            notify()->success('Sua carteira foi cadastrada com sucesso!','Sucesso');
            return redirect()->route('control.wallets.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $wallet = Wallet::find($id);
        return view('admin.wallet.edit', ['wallet' => $wallet]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $credentials = $request->validate([
            'name' => 'required'
        ]);

        $wallet = Wallet::find($id);
        $wallet->fill($request->all());

        var_dump($wallet->save());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
