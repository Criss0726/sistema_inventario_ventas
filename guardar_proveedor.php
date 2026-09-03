<?php

session_start();

// Candado de seguridad
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Incluir conexión a la base de datos
require_once 'conexion.php';

// Verificar que los datos llegaron mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recibir y limpiar los datos
    $empresa = trim($_POST['empresa']);
    $contacto = trim($_POST['contacto']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);

    try {

        // Consulta SQL con marcadores de posición
        $sql = "INSERT INTO proveedores 
                (nombre_empresa, contacto, telefono, direccion)
                VALUES (?, ?, ?, ?)";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros
        // Los cuatro datos son texto: ssss
        $stmt->bind_param(
            "ssss",
            $empresa,
            $contacto,
            $telefono,
            $direccion
        );

        // Ejecutar la consulta
        $stmt->execute();

        // Cerrar la sentencia
        $stmt->close();

        // Regresar a la lista de proveedores
        header("Location: proveedores.php");
        exit();

    } catch (mysqli_sql_exception $e) {

        // Mostrar error
        die(
            "Error crítico al registrar el proveedor: "
            . $e->getMessage()
        );
    }

} else {

    // Si alguien entra directamente a este archivo,
    // regresar a proveedores.php
    header("Location: proveedores.php");
    exit();
}

?>