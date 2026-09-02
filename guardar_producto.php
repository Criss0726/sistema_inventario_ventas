<?php

session_start();

// Verificar que el usuario haya iniciado sesión

if (!isset($_SESSION['user_id'])) {

    header("Location: index.php");
    exit();

}

require_once 'conexion.php';


// Validar que se hayan enviado datos mediante POST

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // 1. Capturar los datos enviados desde el formulario

    $nombre_producto = trim($_POST['nombre']);

    $categoria_id = $_POST['categoria'];

    $stock = $_POST['stock'];

    $precio = $_POST['precio'];


    try {


        // 2. Crear consulta SQL segura

        $sql = "INSERT INTO productos
                (nombre_producto, categoria_id, stock, precio)
                VALUES (?, ?, ?, ?)";


        // 3. Preparar la consulta

        $stmt = $conn->prepare($sql);


        // 4. Vincular los parámetros

        // s = string
        // i = integer
        // i = integer
        // d = decimal/double

        $stmt->bind_param(
            "siid",
            $nombre_producto,
            $categoria_id,
            $stock,
            $precio
        );


        // 5. Ejecutar

        $stmt->execute();


        // 6. Cerrar la sentencia

        $stmt->close();


        // 7. Regresar al inventario

        header("Location: inventario.php");
        exit();


    } catch (mysqli_sql_exception $e) {

        die("Error al registrar el producto: " . $e->getMessage());

    }


} else {

    // Si alguien entra directamente al archivo

    header("Location: inventario.php");
    exit();

}

?>