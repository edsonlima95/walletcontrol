<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AppControlController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;

Route::group(['prefix' => 'control', 'as' => 'control.'], function () {

    Route::get('/signin', [AuthController::class, 'signin'])->name('signin');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/signout', [AuthController::class, 'signout'])->name('signout');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerStore'])->name('register-store');

    Route::middleware(['auth'])->group(function () {

        Route::get('/', [AppControlController::class, 'home'])->name('app');

        Route::get('/wallet-control/{wallet_id?}', [AppControlController::class, 'home'])->name('wallet-control');

        Route::get('/invoice/{type}', [AppControlController::class, 'invoice'])->name('invoice');
        Route::get('/invoice/{id}/edit', [AppControlController::class, 'invoiceEdit'])->name('invoiceEdit');
        Route::put('/invoice/update', [AppControlController::class, 'invoiceUpdate'])->name('invoiceUpdate');
        Route::match(['get', 'post'], '/invoices/{type}', [AppControlController::class, 'invoices'])->name('invoices');
        Route::post('/invoices/status/{id}',[AppControlController::class, 'status'])->name('invoice-onpaid');

        Route::post('/launch', [AppControlController::class, 'launch'])->name('launch');
        Route::get('/fixes', [AppControlController::class, 'fixed'])->name('fixed');

        Route::resource('/users',UserController::class);

        Route::resource('/wallets', WalletController::class);
    });
});
