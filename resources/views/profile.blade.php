<?php
session_start();
include 'db.php';

// Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

// Obtener datos del usuario
$stmt = $pdo->prepare("SELECT name, email, phone FROM Users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Procesar actualización de datos
if (isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Actualizar datos en la base de datos
    $stmt = $pdo->prepare("UPDATE Users SET name = ?, email = ?, phone = ? WHERE user_id = ?");
    $stmt->execute([$name, $email, $phone, $user_id]);

    $message = "Perfil actualizado exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Perfil de Usuario - TopSpin</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        .profile-container {
            max-width: 450px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        h2 {
            color: #ff0000;
            margin-bottom: 25px;
            text-align: center;
        }
        label {
            font-weight: 600;
            margin-top: 15px;
            display: block;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="phone"] {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1.8px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }
        button {
            background-color: #0B4A91;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px;
            margin-top: 25px;
            width: 100%;
            font-weight: 700;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #073b6b;
        }
        .message {
            margin-top: 20px;
            font-weight: 600;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
        }
        .error-message {
            background-color: #f8d7da;
            color: #842029;
        }
        .success-message {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .btn-back {
    background-color: #6c757d;
    margin-top: 20px;  /* Ajustamos un poco la distancia */
    font-size: 16px;
    padding: 12px 20px;
    width: auto;
    display: inline-block;
    text-align: center;
    color: white;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
    border: none;  /* Quitar borde de enlace */
    text-decoration: none; /* Eliminar subrayado */
    display: block;  /* Hacer que el botón ocupe el espacio completo disponible */
    margin: 20px auto 0 auto; /* Centrado en el contenedor */
}

.btn-back:hover {
    background-color: #565e64;
}

    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Perfil de Usuario</h2>

        <?php if (!empty($message)): ?>
            <p class="message <?= !empty($message_class) ? $message_class : 'success-message' ?>"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="profile.php">
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required />

            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required />

            <label for="phone">Teléfono:</label>
            <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($user['phone']) ?>" required />

            <button type="submit" name="update_profile">Actualizar perfil</button>
        </form>

        <!-- Botón para regresar -->
        <a href="products.php" class="btn-back">Volver al catálogo</a>
    </div>
</body>
</html>
