<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

<h1>Bienvenido</h1>

<p>Nombre: <?php echo $_SESSION['nombre']; ?></p>
<p>Rol: <?php echo $_SESSION['rol']; ?></p>

<a href="logout.php">Cerrar sesión</a>

</body>
</html>