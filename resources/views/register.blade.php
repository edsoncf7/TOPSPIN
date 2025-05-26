<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registro de Usuario - TopSpin</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <div class="logo-section">
            <img src="../img/logo.png" alt="TopSpin Logo" class="logo flipped" />
        </div>
        <div class="form-section">
            <h2>Regístrate</h2>
            <form action="register.php" method="POST">
                <input type="text" name="name" placeholder="Nombre completo" required />
                <input type="email" name="email" placeholder="Correo electrónico" required />
                <input type="text" name="phone" placeholder="Teléfono" required />
                <input type="password" name="password" placeholder="Contraseña" required />
                <button type="submit" name="register">Registrarse</button>
                <p class="login-prompt">
                    ¿Ya tienes cuenta? 
                    <a href="login.php" class="login-link">Iniciar sesión</a>
                </p>
            </form>
        </div>
    </div>

 <?php
            if (isset($_POST['register'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $sql = "INSERT INTO Users (name, email, phone, password_hash) 
                        VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $email, $phone, $password]);

                echo '<div id="notification" class="notification success">';
                echo '¡Usuario registrado exitosamente!';
                echo '</div>';
            }
            ?>
<script>
window.onload = function() {
    const notification = document.getElementById('notification');
    if (notification) {
        notification.classList.add('show');
        
        document.getElementById('nextBtn').addEventListener('click', () => {
            // Cambia la URL de destino aquí, por ejemplo al login
            window.location.href = 'login.php';
        });
    }
};
</script>

</body>
</html>
