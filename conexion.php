<?php

$host = "localhost";
$username = "root";
$password = "";
$db_name = "sistema_inventario";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    $conn = new mysqli(
        $host,
        $username,
        $password,
        $db_name
    );

    $conn->set_charset("utf8");

} catch (mysqli_sql_exception $e) {

    die("Error de conexión con la base de datos.");

}

?>