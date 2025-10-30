<?php
include 'db.php';

$mensaje = "";

// Aprobación o rechazo de empresa
if (isset($_POST['accion']) && isset($_POST['id_empresa'])) {
    $id = $_POST['id_empresa'];
    $accion = $_POST['accion'];

    if ($accion == "aprobar") {
        $comision = $_POST['comision'] ?? 0;
        $sql = "UPDATE empresas SET estado='aprobada', comision='$comision' WHERE id_empresa=$id";
    } elseif ($accion == "rechazar") {
        $sql = "UPDATE empresas SET estado='rechazada' WHERE id_empresa=$id";
    }

    if ($conn->query($sql)) {
        $mensaje = "Acción realizada correctamente.";
    } else {
        $mensaje = "Error: " . $conn->error;
    }
}

// Consultar empresas pendientes
$sql = "SELECT * FROM empresas WHERE estado='pendiente'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Administrador - La Cuponera SV</title>
    <link rel="stylesheet" href="css/estilo.css"> 
    <style>
    body {
        background: linear-gradient(to right, #003366, #000c3b);
        color: white;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    table {
        width: 90%;
        margin: 30px auto;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
    }

    th {
        background-color: rgba(255, 255, 255, 0.1);
        font-size: 1.1em;
    }

    td {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    input[type="number"] {
        width: 80px;
        padding: 5px;
        border-radius: 5px;
        border: none;
        margin-right: 10px;
    }

    button {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 7px 15px;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 8px;
        transition: 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
    }

    .mensaje {
        text-align: center;
        color: #00ff88;
        font-weight: bold;
    }
</style>

</head>
<body>
    <header>
        <h1>Panel del Administrador</h1>
        <nav>
            
        </nav>
    </header>

    <main>
        <h2>Empresas Pendientes de Aprobación</h2>
        <?php if ($mensaje != "") echo "<p class='mensaje'>$mensaje</p>"; ?>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>NIT</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acción</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['nombre'] ?></td>
                    <td><?= $row['nit'] ?></td>
                    <td><?= $row['correo'] ?></td>
                    <td><?= $row['telefono'] ?></td>
                    <td>
                        <form method="POST" action="" style="display:inline-block;">
                            <input type="hidden" name="id_empresa" value="<?= $row['id_empresa'] ?>">
                            <input type="hidden" name="accion" value="aprobar">
                            <input type="number" name="comision" placeholder="Comisión %" required min="0" max="100">
                            <button type="submit">Aprobar</button>
                        </form>
                        <form method="POST" action="" style="display:inline-block;">
                            <input type="hidden" name="id_empresa" value="<?= $row['id_empresa'] ?>">
                            <input type="hidden" name="accion" value="rechazar">
                            <button type="submit">Rechazar</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No hay empresas pendientes de aprobación.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p></p>
    </footer>
</body>
</html>
