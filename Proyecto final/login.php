<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contraseña = $_POST['password'];

    try {
        echo loginUser($email, $contraseña);
    } catch (PDOException $e) {
        die('{"status":0,"mensaje":"Error al iniciar sesión: ' . $e->getMessage() . '"}');
    }
}
?>
