<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Usuario;
use App\Http\Controllers\ProductoController;
use App\Models\Reserva;

/*
|--------------------------------------------------------------------------
| Páginas de Productos
|--------------------------------------------------------------------------
*/

// Página principal redirige al catálogo
Route::get('/', fn () => redirect('/productos'));

// Vista de catálogo con productos desde la base de datos
Route::get('/productos', function () {
    $products = Producto::all();
    return view('productos', compact('products'));
})->name('productos');

// Crear y guardar producto (solo usuarios autenticados)
Route::get('/productos/crear', [ProductoController::class, 'create'])->middleware('auth');
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/

// Vista del formulario de login
Route::get('/login', fn () => view('auth.login'))->name('login')->middleware('guest');

// Procesamiento del login
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt([
        'email' => $credentials['email'],
        'contraseña' => $credentials['password'] // ⚠️ Usa el campo correcto de tu tabla
    ])) {
        $request->session()->regenerate();
        return redirect('/profile');
    }

    return back()->with('error', 'Correo o contraseña incorrectos');
});

// Vista del perfil protegida
Route::view('/profile', 'profile')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Registro de Usuarios
|--------------------------------------------------------------------------
*/

// Vista de registro
Route::get('/register', fn () => view('auth.register'))->middleware('guest');

// Procesamiento del registro
Route::post('/register', function (Request $request) {
    $usuario = new Usuario();
    $usuario->nombreUsuario = $request->nombre;
    $usuario->email = $request->email;
    $usuario->contraseña = bcrypt($request->password);
    $usuario->save();

    Auth::login($usuario);
    return redirect('/citas');
});

/*
|--------------------------------------------------------------------------
| Citas o Reservas
|--------------------------------------------------------------------------
*/

// Vista para agendar cita (autenticado)
Route::get('/citas', fn () => view('citas.create'))->middleware('auth');

// Procesamiento de cita
Route::post('/citas', function (Request $request) {
    $cita = new Reserva(); // usa el modelo Reserva correctamente definido
    $cita->idCliente = Auth::user()->idUsuario; // o idCliente si lo usas
    $cita->fechaReserva = $request->fecha;
    $cita->horaInicio = $request->hora;
    $cita->estadoReserva = 'Pendiente';
    $cita->save();

    return redirect('/productos')->with('success', 'Cita agendada correctamente.');
});

/*
|--------------------------------------------------------------------------
| Cierre de sesión
|--------------------------------------------------------------------------
*/

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/productos');
});
