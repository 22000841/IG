<?php
// Función para establecer la conexión a la base de datos
function getConnection() {
    $host = "127.0.0.1"; // Cambia si es necesario
    $db = "Proyecto"; // Nombre de tu base de datos
    $usuario = "root"; // Tu usuario
    $password = ""; // Tu contraseña

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
}

// Función para registrar un nuevo usuario
function registerUser($nombre, $email, $contraseña) {
    $conn = getConnection();
    $hash_contraseña = password_hash($contraseña, PASSWORD_BCRYPT); // Hashear la contraseña
    $stm = $conn->prepare("INSERT INTO Usuarios (nombre_completo, correo_electronico, contraseña) VALUES (:nombre, :email, :contraseña)");
    $stm->bindParam(':nombre', $nombre);
    $stm->bindParam(':email', $email);
    $stm->bindParam(':contraseña', $hash_contraseña);
    
    if($stm->execute()) {
        return '{"status":1,"mensaje":"Registro exitoso."}';
    } else {
        return '{"status":0,"mensaje":"Error al registrar el usuario."}';
    }
}

// Función para iniciar sesión
function loginUser($email, $contraseña) {
    $conn = getConnection();
    $stm = $conn->prepare("SELECT * FROM Usuarios WHERE correo_electronico = :email");
    $stm->bindParam(':email', $email);
    $stm->execute();
    $usuario = $stm->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
        session_start();
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre_completo'] = $usuario['nombre_completo'];
        return '{"status":1,"mensaje":"Inicio de sesión exitoso."}';
    } else {
        return '{"status":0,"mensaje":"Correo o contraseña incorrectos."}';
    }
}
?>