<?php
require 'conexion.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: listado.php');
    exit;
}

$id = $_GET['id'];

// Preparamos la consulta
$stmt = $pdo->prepare('SELECT * FROM productos WHERE id = ?');
$stmt->execute([$id]);

// Obtenemos el producto
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    header('Location: listado.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
</head>
<body class="container mt-4">
    <h1 style="color: white;">Detalles del Producto</h1>
    <p><strong>Codigo:</strong> <?= htmlspecialchars($producto['id']) ?></p>
    <p><strong>Nombre:</strong> <?= htmlspecialchars($producto['nombre']) ?></p>
    <p><strong>Nombre Corto:</strong> <?= htmlspecialchars($producto['nombre_corto']) ?></p>
    <p><strong>PVP</strong> <?= htmlspecialchars($producto['pvp']) ?>$</p>
    <p><strong>Familia:</strong> <?= htmlspecialchars($producto['familia']) ?></p>
    <a href="listado.php" class="btn btn-dark">Atrás</a>
</body>
</html>
