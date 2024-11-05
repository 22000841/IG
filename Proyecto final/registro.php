<?php
// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    // Aquí puedes agregar validaciones y guardar los datos en la base de datos
    if ($contraseña === $confirmar_contraseña) {
        echo "Registro exitoso. Nombre: $nombre, Correo: $email";
        // Aquí podrías agregar código para guardar el usuario en la base de datos
    } else {
        echo "Las contraseñas no coinciden.";
    }
} else {
    echo "No se ha enviado el formulario.";
}
?>
