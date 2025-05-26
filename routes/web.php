<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Página de inicio: redirige al login
Route::get('/', function () {
    return redirect('/login');
});

// Vista del formulario de login
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

// Procesamiento del formulario de login
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt([
        'email' => $credentials['email'],
        'contraseña' => $credentials['password'] // tu campo real
    ])) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->with('error', 'Correo o contraseña incorrectos');
});


// Rutas protegidas por login
Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard');
    Route::view('/profile', 'profile');
    Route::view('/products', 'products');
    Route::view('/settings', 'settings');

    // Cierre de sesión
    Route::get('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    });
});
