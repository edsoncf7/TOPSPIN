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
$message_class = "";

// Procesar formulario de actualización de contraseña
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Obtener hash actual de la contraseña
    $stmt = $pdo->prepare("SELECT password_hash FROM Users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user && password_verify($current_password, $user['password_hash'])) {
        if ($new_password === $confirm_password) {
            // Validación server-side opcional
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE Users SET password_hash = ? WHERE user_id = ?");
            $update->execute([$new_password_hash, $user_id]);
            $message = "Contraseña cambiada exitosamente.";
            $message_class = "success-message";
        } else {
            $message = "La nueva contraseña y la confirmación no coinciden.";
            $message_class = "error-message";
        }
    } else {
        $message = "La contraseña actual es incorrecta.";
        $message_class = "error-message";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Ajustes de Usuario - TopSpin</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        .settings-container {
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
        input[type="password"] {
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
        .password-toggle {
            position: relative;
            margin-top: 6px;
        }   
        .toggle-btn {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  background: transparent;
  border: none;
  padding: 0;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  outline: none; /* Para quitar el contorno al hacer clic */
  user-select: none;
  transition: none; /* Quita cualquier transición */
}



        .eye-icon {
            transition: opacity 0.3s ease;
            stroke: #ff0000;
        }
        .eye-icon.closed {
            opacity: 0.3;
        }
        .btn-back {
            background-color: #6c757d;
            margin-top: 10px;
            font-size: 16px;
        }
        .btn-back:hover {
            background-color: #565e64;
        }
        .password-requirements {
            font-size: 0.9rem;
            margin-top: 10px;
            color: #555;
        }
        .password-requirements span {
            display: block;
            margin-top: 4px;
        }
        .valid {
            color: green;
        }
        .invalid {
            color: red;
        }
    </style>
</head>
<body>
    <div class="settings-container">
        <h2>Ajustes de Usuario</h2>

        <form method="POST" action="settings.php" id="passwordForm">
            <label for="current_password">Contraseña actual:</label>
            <div class="password-toggle">
                <input type="password" name="current_password" id="current_password" required />
                <button type="button" class="toggle-btn" data-target="current_password" aria-label="Mostrar/Ocultar contraseña">
                    <svg class="eye-icon closed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>

            <label for="new_password">Nueva contraseña:</label>
            <div class="password-toggle">
                <input type="password" name="new_password" id="new_password" required />
                <button type="button" class="toggle-btn" data-target="new_password" aria-label="Mostrar/Ocultar contraseña">
                    <svg class="eye-icon closed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>

            <label for="confirm_password">Confirmar nueva contraseña:</label>
            <div class="password-toggle">
                <input type="password" name="confirm_password" id="confirm_password" required />
                <button type="button" class="toggle-btn" data-target="confirm_password" aria-label="Mostrar/Ocultar contraseña">
                    <svg class="eye-icon closed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>

            <div class="password-requirements" id="passwordRequirements">
                <span id="length" class="invalid">• Mínimo 8 caracteres</span>
                <span id="uppercase" class="invalid">• Al menos una letra mayúscula</span>
                <span id="lowercase" class="invalid">• Al menos una letra minúscula</span>
                <span id="number" class="invalid">• Al menos un número</span>
                <span id="special" class="invalid">• Al menos un carácter especial (!@#$%^&*)</span>
            </div>

            <button type="submit" name="change_password">Cambiar contraseña</button>
            <button type="button" class="btn-back" onclick="history.back()">Volver</button>
        </form>

        <?php if (!empty($message)): ?>
            <p class="message <?= $message_class ?>"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    </div>

    <script>
        // Mostrar/ocultar contraseña con iconos
        document.querySelectorAll('.toggle-btn').forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const svg = button.querySelector('.eye-icon');

                if (input.type === 'password') {
                    input.type = 'text';
                    svg.classList.remove('closed');
                } else {
                    input.type = 'password';
                    svg.classList.add('closed');
                }
            });
        });

        // Validación de contraseña en tiempo real
        const newPasswordInput = document.getElementById('new_password');
        const requirements = {
            length: document.getElementById('length'),
            uppercase: document.getElementById('uppercase'),
            lowercase: document.getElementById('lowercase'),
            number: document.getElementById('number'),
            special: document.getElementById('special')
        };

        newPasswordInput.addEventListener('input', () => {
            const val = newPasswordInput.value;

            requirements.length.classList.toggle('valid', val.length >= 8);
            requirements.length.classList.toggle('invalid', val.length < 8);

            requirements.uppercase.classList.toggle('valid', /[A-Z]/.test(val));
            requirements.uppercase.classList.toggle('invalid', !/[A-Z]/.test(val));

            requirements.lowercase.classList.toggle('valid', /[a-z]/.test(val));
            requirements.lowercase.classList.toggle('invalid', !/[a-z]/.test(val));

            requirements.number.classList.toggle('valid', /[0-9]/.test(val));
            requirements.number.classList.toggle('invalid', !/[0-9]/.test(val));

            requirements.special.classList.toggle('valid', /[!@#$%^&*]/.test(val));
            requirements.special.classList.toggle('invalid', !/[!@#$%^&*]/.test(val));
        });

        // Validar requisitos antes de enviar el formulario
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const val = newPasswordInput.value;
            const allValid = val.length >= 8 &&
                             /[A-Z]/.test(val) &&
                             /[a-z]/.test(val) &&
                             /[0-9]/.test(val) &&
                             /[!@#$%^&*]/.test(val);

            if (!allValid) {
                e.preventDefault();
                alert('La contraseña debe tener mínimo 8 caracteres, incluir mayúsculas, minúsculas, números y caracteres especiales.');
            }
        });
    </script>
</body>
</html>
