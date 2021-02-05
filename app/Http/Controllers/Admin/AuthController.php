<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login as LoginRequest;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Requests\User as UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function signin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate( [
            'email' => 'required',
            'password' => 'required|min:4'
        ]);

        if (!Auth::attempt($credentials)) {
            notify()->error('E-mail ou senha não conferem, pfv verifique os dados e tente novamente!', 'Erro');
            return redirect()->route('control.signin')->withInput();
        }

        $user = User::where('email', $credentials['email'])->first();
        $walletFree = Wallet::where('user_id', $user->id)->get();

        if (!$walletFree->count()) {
            Wallet::create([
                'user_id' => $user->id,
                'name' => 'Carteira Padrão',
                'description' => 'carteira free',
                'signature' => 'free'
            ]);
        }

        $walletFree = $user->wallets()->where('signature', 'free')->first();
        session()->put('wallet', $walletFree->id);

        return redirect()->route('control.app');
    }

    public function register()
    {
        return view('admin.register');
    }

    public function registerStore(Request $request)
    {
        $credentials = $request->validate([
            'first_name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);
        $credentials['last_name'] = $request->last_name;
        $userCreate = User::create($credentials);

        if ($request->file('cover')) {
            $userCreate->cover = $request->file('cover')->store('user');
            $userCreate->save();
        }

        if ($userCreate) {
            notify()->success('Cadastro criado com sucesso, efetue o login e comece a controlar!', 'Sucesso');
            return redirect()->route('control.signin');
        }
    }

    public function signout()
    {
        Auth::logout();
        return redirect()->route('control.signin');
    }
}
