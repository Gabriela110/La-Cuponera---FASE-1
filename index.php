<?php
include 'db.php';

// Consultar ofertas disponibles
$sql = "SELECT ofertas.id_oferta, ofertas.titulo, ofertas.precio_oferta, ofertas.descripcion, empresas.nombre_empresa
        FROM ofertas
        INNER JOIN empresas ON ofertas.id_empresa = empresas.id_empresa
        WHERE ofertas.estado='disponible'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La Cuponera SV</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>
        <h1>La Cuponera SV</h1>
        <a href="login.php">Iniciar sesión</a>
    </header>

    <h2>Ofertas disponibles</h2>

    <?php
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {
            echo "<div class='oferta'>";
            echo "<h3>" . $row['titulo'] . "</h3>";
            echo "<p><strong>Empresa:</strong> " . $row['nombre_empresa'] . "</p>";
            echo "<p><strong>Precio de oferta:</strong> $" . $row['precio_oferta'] . "</p>";
            echo "<p>" . $row['descripcion'] . "</p>";
            echo "</div>";
        }
    } 
    
    else 
    {
        echo "<p>No hay ofertas disponibles por el momento.</p>";
    }
    ?>

    <footer>
        © 2025 La Cuponera SV
    </footer>
</body>
</html>

