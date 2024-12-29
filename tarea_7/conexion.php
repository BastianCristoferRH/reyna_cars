<?php
// Datos de la base de datos
$servername = "localhost";  // Nombre del servidor
$username = "root";         // Usuario para acceder a la base de datos
$password = "";             // Contraseña (vacía por defecto en XAMPP)
$nombre_bd = "reynacars";   // Nombre de la base de datos
// Crear la conexión
$connection = new mysqli($servername, $username, $password, $nombre_bd);
if ($connection->connect_error) {
    die("Conexión fallida: " . $connection->connect_error);
}

?>