<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) 
{
    header("Location: login_admin.php");
    exit();
}

$mensaje = "";

//Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    //Encriptar contraseña 
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $verificar = $conn->query("SELECT * FROM administradores WHERE usuario='$usuario' OR correo='$correo'");
    if ($verificar->num_rows > 0) {
        $mensaje = "Ese usuario o correo ya existe.";
    } else {
        $sql = "INSERT INTO administradores (usuario, correo, contraseña) VALUES ('$usuario', '$correo', '$contrasena')";
        if ($conn->query($sql)) {
            $mensaje = "Administrador registrado correctamente.";
        } else {
            $mensaje = "Error al registrar: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registrar Administrador</title>
<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<main class="form-container">
    <h2>Registrar Nuevo Administrador</h2>
    <!-- Formulario para registrar nuevos administradores -->
    <form method="POST" action="">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>

        <label>Correo:</label>
        <input type="email" name="correo" required>

        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>

        <button type="submit">Registrar</button>

        <?php if($mensaje != "") echo "<p class='mensaje'>$mensaje</p>"; ?>
    </form>
</main>
</body>
</html>
