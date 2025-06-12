<?php
$server = "localhost";
$bd = "bd_ugel";
$user = "postgres";  // Usuario PostgreSQL por defecto
$pass = "1234";  // Cambia esto por tu contraseña
$port = "5432";  // Puerto predeterminado para PostgreSQL

try {
    // Conexión a PostgreSQL
    $conectar = new PDO("pgsql:host=$server;port=$port;dbname=$bd", $user, $pass);
    // Configurar el manejo de errores para PDO
    $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo"conectado";
} catch (\Throwable $th) {
    echo "" . $th->getMessage();
}
?>