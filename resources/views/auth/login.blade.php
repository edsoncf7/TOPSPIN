<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Iniciar Sesión - TopSpin</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="text-center mb-4">
        <img src="{{ asset('img/logotopspin.jpg') }}" alt="TopSpin Logo" class="img-fluid" style="max-width: 200px;">
    </div>
    <div class="form-section">
        <h2>INICIAR SESIÓN</h2>
        {{-- Mensaje de error de login --}}
        @if(session('error'))
            <p class="error-message">{{ session('error') }}</p>
        @endif
        {{-- Formulario de login Laravel --}}
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="email" name="email" required>
            <input type="password" name="password" required>
            <button type="submit">Iniciar sesión</button>
        </form>

        <p class="register-prompt">
            ¿No tienes cuenta? 
            <a href="{{ url('/register') }}" class="register-link">Regístrate</a>
        </p>
    </div>
</div>
</body>
</html>