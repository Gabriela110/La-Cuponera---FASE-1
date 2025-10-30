<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel de Administrador - La Cuponera SV</title>
<link rel="stylesheet" href="../css/estilo.css">
<style>
body {
    background: linear-gradient(to right, #003366, #000c3b);
    color: white;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

header {
    background: rgba(0, 0, 0, 0.3);
    padding: 30px;
    text-align: center;
}

h1 {
    margin: 0;
    font-size: 2em;
}

h2 {
    margin-top: 15px;
    font-size: 1.7em;
}

p.subtitulo {
    font-size: 1.1em;
    color: #d1d1d1;
    margin-top: 8px;
}

nav {
    margin-top: 40px;
    text-align: center;
}

nav ul {
    list-style: none;
    padding: 0;
}

nav li {
    display: inline-block;
    margin: 0 12px;
}

nav a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    border: 1px solid white;
    padding: 10px 15px;
    border-radius: 6px;
    transition: 0.3s;
}

nav a:hover {
    background-color: white;
    color: #003366;
}

main {
    text-align: center;
    margin-top: 60px;
}

</style>
</head>

<body>
<header>
    <h1>Bienvenido, <?php echo $_SESSION['admin_usuario']; ?></h1>
    <h2>Panel de Control del Administrador</h2>
    <p class="subtitulo">Selecciona una opción del menú para continuar.</p>
</header>

<nav>
    <ul>
        <li><a href="ver_registro.php">Empresas pendientes</a></li>
        <li><a href="registro_admin.php">Registrar nuevo administrador</a></li>
        <li><a href="reportes.php">Reportes</a></li>
        <li><a href="logout.php">Cerrar sesión</a></li>
    </ul>
</nav>

</body>
</html>
