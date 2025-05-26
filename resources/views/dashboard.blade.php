<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <h1>¡Bienvenido, {{ Auth::user()->nombreUsuario }}!</h1>
    <a href="/logout" class="btn btn-danger mt-3">Cerrar sesión</a>
</body>
</html>
