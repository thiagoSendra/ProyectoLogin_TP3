<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}
$nombre = htmlspecialchars($_SESSION['usuario_nombre']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Proyecto Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="card dashboard-card">
        <h2>Bienvenido <?php echo $nombre; ?> a tu dashboard</h2>
        <p class="subtitle">Esta es una vista protegida. Aquí podés agregar contenido del sistema.</p>
        <a href="logout.php" class="btn-primary btn-logout">Cerrar sesión</a>
    </div>
</body>
</html>
