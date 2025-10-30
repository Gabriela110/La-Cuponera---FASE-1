<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM administradores WHERE usuario='$usuario'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($contrasena == $row['contraseña']) 
        {
            $_SESSION['admin_id'] = $row['id_admin'];
            $_SESSION['admin_usuario'] = $row['usuario'];
            header("Location: admin.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } 
    else 
    {
        $error = "Administrador no encontrado.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login Administrador - La Cuponera SV</title>
<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<main class="form-container">
    <h2>Inicio de Sesión (Administrador)</h2>
    <form method="POST" action="">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>
        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>
        <button type="submit">Ingresar</button>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
    </form>
</main>
</body>
</html>
