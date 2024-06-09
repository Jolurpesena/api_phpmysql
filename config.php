<?php
// Datos de configuración para la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "api_phpmysql";


// Crear la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);


// Verificar la conexión
if ($conn->connect_error) {
        // Si hay un error en la conexión, se termina el script y se muestra el error
    die("Connection failed: " . $conn->connect_error);
}
?>
