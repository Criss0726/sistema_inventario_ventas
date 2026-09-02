<?php

session_start();

// 1. Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'conexion.php';

// 2. Validar que venga el ID mediante GET
if (isset($_GET['id'])) {

    // Capturar el ID
    $id_producto = $_GET['id'];

    try {

        // 3. Consulta segura
        $sql = "DELETE FROM productos WHERE id = ?";

        // 4. Preparar la consulta
        $stmt = $conn->prepare($sql);

        // 5. El ID es un número entero
        $stmt->bind_param("i", $id_producto);

        // 6. Ejecutar
        $stmt->execute();

        // 7. Cerrar
        $stmt->close();

        // 8. Regresar al inventario
        header("Location: inventario.php");
        exit();

    } catch (mysqli_sql_exception $e) {

        die("Error crítico al intentar eliminar el registro: "
            . $e->getMessage());

    }

} else {

    // Si no viene ID, regresar al inventario
    header("Location: inventario.php");
    exit();
}

?>