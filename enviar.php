<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y sanitizar datos
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = htmlspecialchars(trim($_POST['email']));
    $condicion = htmlspecialchars(trim($_POST['condicion']));
    $asunto = htmlspecialchars(trim($_POST['asunto']));
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    // Validar campos obligatorios
    if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
        header("Location: contacto.html?status=error");
        exit;
    }

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contacto.html?status=error");
        exit;
    }

    // Configurar destinatario y asunto
    $para = "alldesiggn.web@gmail.com";  // <--- CAMBIA AQUÍ POR TU CORREO REAL
    $asunto_correo = "Mensaje desde la web ENCRyM: " . $asunto;

    // Construir cuerpo del mensaje
    $cuerpo = "Has recibido un nuevo mensaje desde el formulario de contacto:\n\n";
    $cuerpo .= "Nombre: $nombre\n";
    $cuerpo .= "Correo: $email\n";
    $cuerpo .= "Condición: $condicion\n";
    $cuerpo .= "Asunto: $asunto\n\n";
    $cuerpo .= "Mensaje:\n$mensaje\n";

    // Cabeceras del correo
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Enviar correo
    if (mail($para, $asunto_correo, $cuerpo, $headers)) {
        // Redirigir de vuelta con mensaje de éxito
        header("Location: contacto.html?status=success");
        exit;
    } else {
        // Error al enviar
        header("Location: contacto.html?status=error");
        exit;
    }
} else {
    // Si alguien intenta acceder directamente al archivo, redirigir al formulario
    header("Location: contacto.html");
    exit;
}
?>