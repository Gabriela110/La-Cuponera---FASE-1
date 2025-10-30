<?php
include 'db.php'; // Conexión a la base de datos

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $nit = $_POST['nit'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    // Validaciones para cada campo
    if (!empty($nombre) && !empty($nit) && !empty($direccion) && !empty($telefono) && !empty($correo) && 
          !empty($usuario) && !empty($_POST['contrasena'])) 
          
    {

        // Verificar NIT o usuario
        $verificar = $conn->query("SELECT * FROM empresas WHERE nit='$nit' OR usuario='$usuario'");
        if ($verificar->num_rows > 0) {
            $mensaje = "Ya existe una empresa registrada con ese NIT o usuario";
        } else {
            // agregar la empresa a la base de datos 
            $sql = "INSERT INTO empresas (nombre, nit, direccion, telefono, correo, usuario, contrasena, estado)
                    VALUES ('$nombre', '$nit', '$direccion', '$telefono', '$correo', '$usuario', '$contrasena', 'pendiente')";
            if ($conn->query($sql)) 
            {
                $mensaje = "Solicitud enviada correctamente. Espere la aprobación del administrador.";
            } 
            else 
            {
                $mensaje = "Error al registrar la empresa: " . $conn->error;
            }
        }
    } 
    else 
    {
        $mensaje = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empresa - La Cuponera SV</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>
        <h1>Registro de Empresa</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="login.php">Iniciar Sesión</a>
        </nav>
    </header>

    <main class="form-container">
        <form method="POST" action="">
            <h2>Formulario de Registro</h2>

            <label>Nombre de la empresa:</label>
            <input type="text" name="nombre" required>

            <label>NIT:</label>
            <input type="text" name="nit" required>

            <label>Dirección:</label>
            <input type="text" name="direccion" required>

            <label>Teléfono:</label>
            <input type="text" name="telefono" required>

            <label>Correo electrónico:</label>
            <input type="email" name="correo" required>

            <label>Usuario:</label>
            <input type="text" name="usuario" required>

            <label>Contraseña:</label>
            <input type="password" name="contrasena" required>

            <button type="submit">Registrar Empresa</button>

            <?php if ($mensaje != "") echo "<p class='mensaje'>$mensaje</p>"; ?>
        </form>
    </main>

    <footer>
        <p>© 2025 La Cuponera SV</p>
    </footer>
</body>
</html>
