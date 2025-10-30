<?php
include 'db.php'; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mensaje = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Tomamos los valores del formulario
    $usuario = trim($_POST['usuario'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $dui = trim($_POST['dui'] ?? '');
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';

    // Validar que todos los campos tengan valor
    if ($usuario && $correo && $contrasena && $nombre && $apellidos && $dui && $fecha_nacimiento) {

        // Validar edad 
        $fecha_actual = new DateTime();
        $fecha_nac = new DateTime($fecha_nacimiento);
        $edad = $fecha_nac->diff($fecha_actual)->y;

        if ($edad < 18) 
        {
            $mensaje = "Debes tener al menos 18 años para registrarte.";
        } 
         
        else 
        {
            
            $usuario_safe = $conn->real_escape_string($usuario);
            $correo_safe = $conn->real_escape_string($correo);
            $nombre_safe = $conn->real_escape_string($nombre);
            $apellidos_safe = $conn->real_escape_string($apellidos);
            $dui_safe = $conn->real_escape_string($dui);

            // Verificar si ya existe el usuario o correo
            $verificar = $conn->query("SELECT * FROM clientes WHERE usuario='$usuario_safe' OR correo='$correo_safe'");

            if ($verificar && $verificar->num_rows > 0) {
                $mensaje = "Ya existe un cliente con ese usuario o correo.";
            } else {
                // Hashear contraseña
                $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

                // Insertar cliente
                $sql = "INSERT INTO clientes (usuario, correo, contrasena, nombre, apellidos, dui, fecha_nacimiento)
                        VALUES ('$usuario_safe', '$correo_safe', '$contrasena_hash', '$nombre_safe', '$apellidos_safe', '$dui_safe', '$fecha_nacimiento')";

                if ($conn->query($sql)) {
                    $mensaje = "Registro exitoso. Ya puedes iniciar sesión.";
                    
                    $usuario = $correo = $nombre = $apellidos = $dui = $fecha_nacimiento = '';
                } 
                
                else 
                {
                    $mensaje = "Error al registrar el cliente: " . $conn->error;
                }
            }
        }

    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Cliente - La Cuponera SV</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>
        <h1>Registro de Cliente</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="login.php">Iniciar Sesión</a>
        </nav>
    </header>

    <main class="form-container">
        <form method="POST" action="">
            <h2>Crear Cuenta</h2>

            <label>Usuario:</label>
            <input type="text" name="usuario" required value="<?php echo htmlspecialchars($usuario ?? ''); ?>">

            <label>Correo electrónico:</label>
            <input type="email" name="correo" required value="<?php echo htmlspecialchars($correo ?? ''); ?>">

            <label>Contraseña:</label>
            <input type="password" name="contrasena" required>

            <label>Nombre:</label>
            <input type="text" name="nombre" required value="<?php echo htmlspecialchars($nombre ?? ''); ?>">

            <label>Apellidos:</label>
            <input type="text" name="apellidos" required value="<?php echo htmlspecialchars($apellidos ?? ''); ?>">

            <label>DUI:</label>
            <input type="text" name="dui" maxlength="10" placeholder="00000000-0" required value="<?php echo htmlspecialchars($dui ?? ''); ?>">

            <label>Fecha de nacimiento:</label>
            <input type="date" name="fecha_nacimiento" required value="<?php echo htmlspecialchars($fecha_nacimiento ?? ''); ?>">

            <button type="submit">Registrarse</button>

            <?php if ($mensaje != "") echo "<p class='mensaje'>" . htmlspecialchars($mensaje) . "</p>"; ?>
        </form>
    </main>

    <footer>
        <p>© 2025 La Cuponera SV</p>
    </footer>
</body>
</html>

