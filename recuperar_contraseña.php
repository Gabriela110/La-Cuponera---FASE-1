<?php
include 'db.php';
$mensaje = "";

ini_set('display_errors', 1);
error_reporting(E_ALL);

// verificar usuario o correo
if (isset($_POST['buscar_usuario'])) {
    $usuario = trim($_POST['usuario'] ?? '');
    $usuario_safe = $conn->real_escape_string($usuario);

    $sql_cliente = $conn->query("SELECT * FROM clientes WHERE usuario='$usuario_safe' OR correo='$usuario_safe'");
    $sql_empresa = $conn->query("SELECT * FROM empresas WHERE usuario='$usuario_safe' OR correo='$usuario_safe'");

    if ($sql_cliente && $sql_cliente->num_rows > 0) {
        $tipo = "cliente";
        $row = $sql_cliente->fetch_assoc();
    } elseif ($sql_empresa && $sql_empresa->num_rows > 0) {
        $tipo = "empresa";
        $row = $sql_empresa->fetch_assoc();
    } else {
        $mensaje = "Usuario o correo no encontrado.";
    }
}

// cambio de contraseña
if (isset($_POST['cambiar_contra'])) {
    $tipo = $_POST['tipo'] ?? '';
    $usuario = trim($_POST['usuario'] ?? '');
    $nueva_contra = $_POST['nueva_contra'] ?? '';

    if ($usuario && $nueva_contra) {
        $usuario_safe = $conn->real_escape_string($usuario);
        $nueva_hash = password_hash($nueva_contra, PASSWORD_DEFAULT);

        if ($tipo == "cliente") {
            $sql = "UPDATE clientes SET contrasena='$nueva_hash' WHERE usuario='$usuario_safe' OR correo='$usuario_safe'";
        } elseif ($tipo == "empresa") {
            $sql = "UPDATE empresas SET contrasena='$nueva_hash' WHERE usuario='$usuario_safe' OR correo='$usuario_safe'";
        } else {
            $mensaje = "Tipo de usuario inválido.";
        }

        if (isset($sql) && $conn->query($sql)) 
        {
            // Redirigir al login
            header("Location: login.php?mensaje=contraseña_actualizada");
            exit();
        } 
        elseif (isset($sql)) 
        {
            $mensaje = "Error al actualizar la contraseña: " . $conn->error;
        }
    } 
    else 
    {
        $mensaje = "Por favor ingrese la nueva contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña - La Cuponera SV</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>
        <h1>Recuperar Contraseña</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="login.php">Iniciar Sesión</a>
        </nav>
    </header>

    <main class="form-container">
        <?php if (!isset($row)) { ?>
            <!-- Formulario para buscar usuario -->
            <form method="POST" action="">
                <h2>Buscar cuenta</h2>
                <label>Usuario o correo electrónico:</label>
                <input type="text" name="usuario" required>
                <button type="submit" name="buscar_usuario">Buscar</button>
                <?php if ($mensaje != "") echo "<p class='mensaje'>" . htmlspecialchars($mensaje) . "</p>"; ?>
            </form>
        <?php } else { ?>
            <!-- Formulario para cambiar contraseña -->
            <form method="POST" action="">
                <h2>Restablecer Contraseña</h2>
                <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
                <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">

                <label>Nueva contraseña:</label>
                <input type="password" name="nueva_contra" required>

                <button type="submit" name="cambiar_contra">Actualizar Contraseña</button>
                <?php if ($mensaje != "") echo "<p class='mensaje'>" . htmlspecialchars($mensaje) . "</p>"; ?>
            </form>
        <?php } ?>
    </main>

    <footer>
        <p>© 2025 La Cuponera SV</p>
    </footer>
</body>
</html>
