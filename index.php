<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit();
}

require_once 'conexion.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];

    if (!empty($correo) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, nombre, password FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            if (password_verify($password, $usuario['password'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "No existe una cuenta con ese correo.";
        }
        $stmt->close();
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Proyecto Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="card">
        <h2>Iniciar sesión</h2>
        <?php if ($error): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form id="formLogin" action="index.php" method="POST" novalidate>
            <div class="form-group">
                <input type="email" id="correo" name="correo" placeholder="Correo @gmail.com" required>
                <small class="hint">Email @gmail.com obligatorio</small>
                <span class="error-msg" id="errorCorreo"></span>
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Contraseña" minlength="8" required>
                <small class="hint">La contraseña es obligatoria (mín 8)</small>
                <span class="error-msg" id="errorPassword"></span>
            </div>

            <button type="submit" class="btn-primary">Ingresar</button>
        </form>

        <div class="links">
            <p>¿No tenés cuenta? <a href="registro.php">Crear una</a></p>
            <p><a href="#" onclick="alert('Funcionalidad de recuperación pendiente.'); return false;">¿Olvidaste la contraseña?</a></p>
        </div>
    </div>
    <script src="validaciones.js"></script>
</body>
</html>
