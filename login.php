<?php
session_start();
include 'db.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? $_POST['contraseña'] ?? '';

    if ($usuario !== '' && $contrasena !== '') {
        $roles = [
            'administradores' => ['rol' => 'admin', 'redir' => 'admin.php'],
            'empresas'        => ['rol' => 'empresa', 'redir' => 'panel_empresa.php'],
            'clientes'        => ['rol' => 'cliente', 'redir' => 'index.php']
        ];

        $encontrado = false;

        foreach ($roles as $tabla => $info) {
            $usuario_seguro = $conn->real_escape_string($usuario);
            $sql = "SELECT * FROM $tabla WHERE usuario='$usuario_seguro' OR correo='$usuario_seguro' LIMIT 1";
            $res = $conn->query($sql);

            if ($res && $res->num_rows > 0) {
                $fila = $res->fetch_assoc();
                $encontrado = true;

                $hash_en_bd = $fila['contrasena'] ?? $fila['contraseña'] ?? null;

                if (!$hash_en_bd) {
                    $mensaje = "Error: el registro no tiene campo de contraseña definido.";
                    break;
                }

                if (password_verify($contrasena, $hash_en_bd)) {
                    if ($tabla === 'empresas' && isset($fila['estado']) && $fila['estado'] !== 'aprobada') {
                        $mensaje = "Su empresa aún no ha sido aprobada.";
                        break;
                    }

                    $_SESSION['rol'] = $info['rol'];
                    $_SESSION['usuario'] = $fila['usuario'] ?? $fila['correo'] ?? $usuario_seguro;

                    if (isset($fila['id_empresa'])) $_SESSION['id_empresa'] = $fila['id_empresa'];
                    if (isset($fila['id_cliente'])) $_SESSION['id_cliente'] = $fila['id_cliente'];
                    if (isset($fila['id_admin'])) $_SESSION['id_admin'] = $fila['id_admin'];

                    header("Location: " . $info['redir']);
                    exit();
                } else {
                    $mensaje = "Contraseña incorrecta.";
                    break;
                }
            }
        }

        if (!$encontrado) {
            $mensaje = "Usuario no encontrado.";
        }
    } else {
        $mensaje = "Por favor complete todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - La Cuponera SV</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>
        <h1>Iniciar Sesión</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="registro_empresa.php">Registrar Empresa</a>
            <a href="registro_clientes.php">Registrar Cliente</a>
        </nav>
    </header>

    <main class="form-container">
        <form method="POST" action="">
            <h2>Bienvenid@!</h2>
            <label>Usuario:</label>
            <input type="text" name="usuario" required>

            <label>Contraseña:</label>
            <input type="password" name="contrasena" required>

            <button type="submit">Ingresar</button>

            <p><a href="recuperar_contraseña.php">¿Olvidaste tu contraseña?</a></p>

            <?php if ($mensaje != "") echo "<p class='mensaje'>$mensaje</p>"; ?>
        </form>
    </main>

    <footer>
        <p>© 2025 La Cuponera SV</p>
    </footer>
</body>
</html>




