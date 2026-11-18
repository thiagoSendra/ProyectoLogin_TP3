<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit();
}

require_once 'conexion.php';
$error = "";
$exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($nombre) || empty($apellido) || empty($correo) || empty($password) || empty($confirm_password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } elseif (strlen($password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    } else {
        $check = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $check->bind_param("s", $correo);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "El correo electrónico ya está registrado.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, correo, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nombre, $apellido, $correo, $password_hash);

            if ($stmt->execute()) {
                $exito = "Cuenta creada con éxito. Ya podés iniciar sesión.";
            } else {
                $error = "Error al registrar el usuario.";
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Proyecto Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="card">
        <h2>Crear Cuenta</h2>
        <?php if ($error): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($exito): ?>
            <div class="alert success"><?php echo htmlspecialchars($exito); ?></div>
        <?php endif; ?>

        <form id="formRegistro" action="registro.php" method="POST" novalidate>
            <div class="form-group">
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                <small class="hint">El nombre es obligatorio</small>
                <span class="error-msg" id="errorNombre"></span>
            </div>

            <div class="form-group">
                <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>
                <small class="hint">El apellido es obligatorio</small>
                <span class="error-msg" id="errorApellido"></span>
            </div>

            <div class="form-group">
                <input type="email" id="correo" name="correo" placeholder="Correo @gmail.com" required>
                <small class="hint">Email @gmail.com obligatorio</small>
                <span class="error-msg" id="errorCorreo"></span>
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
                <small class="hint">Mín 8 chars, mayúscula, minúscula, número y símbolo</small>
                <span class="error-msg" id="errorPassword"></span>
            </div>

            <div class="form-group">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Repetir contraseña" required>
                <span class="error-msg" id="errorConfirmPassword"></span>
            </div>

            <button type="submit" class="btn-primary">Crear Cuenta</button>
        </form>

        <div class="links">
            <p>¿Ya tenés cuenta? <a href="index.php">Iniciar sesión</a></p>
        </div>
    </div>
    <script src="validaciones.js"></script>
</body>
</html>
