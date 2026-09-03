<?php

session_start();

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Conectar con la base de datos
require_once 'conexion.php';


// Verificar que los datos hayan llegado mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Capturar datos de la sesión y del formulario

    $usuario_id = $_SESSION['user_id'];

    $proveedor_id = $_POST['proveedor_id'];

    $producto_id = $_POST['producto_id'];

    $cantidad = $_POST['cantidad'];

    $precio_compra = $_POST['precio_compra'];


    // Calcular el total de la compra

    $total_compra = $cantidad * $precio_compra;


    try {


        // ==========================================================
        // FASE 1: INSERTAR LA CABECERA DE LA COMPRA
        // ==========================================================

        $sql_compras = "
            INSERT INTO compras
            (proveedor_id, usuario_id, total)
            VALUES (?, ?, ?)
        ";

        $stmt1 = $conn->prepare($sql_compras);


        // proveedor_id = Integer
        // usuario_id   = Integer
        // total        = Double

        $stmt1->bind_param(
            "iid",
            $proveedor_id,
            $usuario_id,
            $total_compra
        );


        // Ejecutar INSERT de compras

        $stmt1->execute();


        // ==========================================================
        // CAPTURAR EL ID GENERADO POR MYSQL
        // ==========================================================

        $id_nueva_compra = $conn->insert_id;


        // Cerrar sentencia

        $stmt1->close();


        // ==========================================================
        // FASE 2: INSERTAR EL DETALLE DE LA COMPRA
        // ==========================================================

        $sql_detalle = "
            INSERT INTO detalle_compras
            (compra_id, producto_id, cantidad, precio_compra)
            VALUES (?, ?, ?, ?)
        ";


        $stmt2 = $conn->prepare($sql_detalle);


        // compra_id    = Integer
        // producto_id  = Integer
        // cantidad     = Integer
        // precio       = Double

        $stmt2->bind_param(
            "iiid",
            $id_nueva_compra,
            $producto_id,
            $cantidad,
            $precio_compra
        );


        // Ejecutar INSERT del detalle

        $stmt2->execute();


        // Cerrar sentencia

        $stmt2->close();


        // ==========================================================
        // REGISTRO EXITOSO
        // ==========================================================

        header("Location: dashboard.php");

        exit();


    } catch (mysqli_sql_exception $e) {


        // Mostrar mensaje de error

        die(
            "Error crítico en la transacción Maestro-Detalle: "
            . $e->getMessage()
        );

    }


} else {


    // Si alguien entra directamente a este archivo

    header("Location: dashboard.php");

    exit();

}

?>