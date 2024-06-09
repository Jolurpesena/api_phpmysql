<?php
// Incluir el archivo de configuración para conectar a la base de datos
include 'config.php';

// Obtener los datos enviados en la solicitud (en formato JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Verificar que se hayan enviado el nombre de usuario y la contraseña
if (isset($data['username']) && isset($data['password'])) {
    $username = $data['username'];
    // Encriptar la contraseña utilizando el algoritmo bcrypt
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar un nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    // Ejecutar la consulta y verificar si fue exitosa
    if ($stmt->execute()) {
        // Si el registro fue exitoso, enviar un mensaje de confirmación
        echo json_encode(["message" => "Registro correctamente"]);
    } else {
        // Si hubo un error al registrar, enviar un mensaje de error
        echo json_encode(["error" => "Error al registrar, datos incompletos o no es un JSON"]);
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

