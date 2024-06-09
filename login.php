<?php
// Incluir el archivo de configuración para conectar a la base de datos
include 'config.php';


// Obtener los datos enviados en la solicitud (en formato JSON)
$data = json_decode(file_get_contents('php://input'), true);


// Verificar que se hayan enviado el nombre de usuario y la contraseña
if (isset($data['username']) && isset($data['password'])) {
    $username = $data['username'];
    $password = $data['password'];



    // Preparar la consulta SQL para obtener la contraseña encriptada del usuario
    $stmt = $conn->prepare("SELECT password FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hash);
    $stmt->fetch();

    // Verificar si la contraseña ingresada coincide con la contraseña encriptada en la base de datos
    if (password_verify($password, $hash)) {
        // Si la autenticación es exitosa, enviar un mensaje de confirmación
        echo json_encode(["message" => "Autenticacion es Correcta"]);
    } else {
        // Si la autenticación falla, enviar un mensaje de error
        echo json_encode(["error" => "Error en la autenticacion, verifique usuario y contraseña"]);
    }

    // Cerrar la declaración preparada
    $stmt->close();
} else {
    // Si no se enviaron todos los datos necesarios, enviar un mensaje de error
    echo json_encode(["error" => "Datos incompletos"]);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
