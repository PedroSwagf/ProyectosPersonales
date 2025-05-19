<?php

require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $nombre = $_POST['nombre'];
    $nombre_corto = $_POST['nombre_corto'];
    $descripcion = $_POST['descripcion'];
    $pvp = $_POST['pvp'];
    $familia = $_POST['familia'];

    // Validamos que los datos obligatorios no esten vacios
    if (empty($nombre) || empty($nombre_corto) || empty($pvp) || empty($familia)) {
        header('Location: listado.php?mensaje=' . urlencode('Error: Todos los campos obligatorios deben estar completos.') . '&tipo=warning');
        exit;
    }
    // Verificar unicidad de nombre_corto
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM productos WHERE nombre_corto = ?');
    $stmt->execute([$nombre_corto]);
    if ($stmt->fetchColumn() > 0) {
        header('Location: listado.php?mensaje=' . urlencode('Error: El nombre corto ya existe.') . '&tipo=warning');
        exit;
    }

    try {
        // Preparar consulta de inserción
        $stmt = $pdo->prepare('INSERT INTO productos (nombre, nombre_corto, descripcion, pvp, familia) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$nombre, $nombre_corto, $descripcion, $pvp, $familia]);

        // Redirigir con mensaje de éxito
        header('Location: listado.php?mensaje=' . urlencode('El producto se agregó correctamente.') . '&tipo=success');
        exit;
    } catch (PDOException $e) {
        header('Location: listado.php?mensaje=' . urlencode('Error al insertar en la base de datos: ' . $e->getMessage()) . '&tipo=danger');
        exit;
    }
}

$familias = $pdo->query('SELECT cod, nombre FROM familias')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
</head>
<body class="container mt-4">
    <h1 style="color: white;">Crear Nuevo Producto</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label" style="color: white;">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nombre_corto" class="form-label" style="color: white;">Nombre Corto</label>
            <input type="text" id="nombre_corto" name="nombre_corto" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label" style="color: white;">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="pvp" class="form-label" style="color: white;">PVP</label>
            <input type="number" id="pvp" name="pvp" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="familia" class="form-label" style="color: white;">Familia</label>
            <select id="familia" name="familia" class="form-control" required>
                <?php foreach ($familias as $familia): ?>
                    <option value="<?= htmlspecialchars($familia['cod']) ?>"><?= htmlspecialchars($familia['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Crear</button>
    </form>
    <a href="listado.php" class="btn btn-dark">Atrás</a>
</body>
</html>
