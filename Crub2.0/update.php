<?php
require 'conexion.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: listado.php?mensaje=' . urlencode('Error: ID no válido.') . '&tipo=warning');
    exit;
}

$id = $_GET['id'];

// Consultar los datos actuales del producto
$stmt = $pdo->prepare('SELECT * FROM productos WHERE id = ?');
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si el producto existe
if (!$producto) {
    header('Location: listado.php?mensaje=' . urlencode('Error: Producto no encontrado.') . '&tipo=warning');
    exit;
}

// Obtener las familias 
$familias = $pdo->query('SELECT cod, nombre FROM familias')->fetchAll(PDO::FETCH_ASSOC);

// Procesar el formulario al enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $nombre_corto = $_POST['nombre_corto'];
    $descripcion = $_POST['descripcion'];
    $pvp = $_POST['pvp'];
    $familia = $_POST['familia'];

    // Validar los datos obligatorios
    if (empty($nombre) || empty($nombre_corto) || empty($pvp) || empty($familia)) {
        header('Location: update.php?id=' . $id . '&mensaje=' . urlencode('Error: Todos los campos obligatorios deben estar completos.') . '&tipo=warning');
        exit;
    }

    // Verificar  nombre_corto
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM productos WHERE nombre_corto = ? AND id != ?');
    $stmt->execute([$nombre_corto, $id]);
    if ($stmt->fetchColumn() > 0) {
        header('Location: update.php?id=' . $id . '&mensaje=' . urlencode('Error: El nombre corto ya existe.') . '&tipo=warning');
        exit;
    }

    try {
        // Actualizar los datos del producto
        $stmt = $pdo->prepare('UPDATE productos SET nombre = ?, nombre_corto = ?, descripcion = ?, pvp = ?, familia = ? WHERE id = ?');
        $stmt->execute([$nombre, $nombre_corto, $descripcion, $pvp, $familia, $id]);

        header('Location: listado.php?mensaje=' . urlencode('Producto actualizado correctamente.') . '&tipo=success');
        exit;
    } catch (PDOException $e) {
        header('Location: update.php?id=' . $id . '&mensaje=' . urlencode('Error al actualizar el producto: ' . $e->getMessage()) . '&tipo=danger');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
</head>
<body class="container mt-4">
    <h1 style="color: white;">Actualizar Producto</h1>

    <!-- Mostrar mensaje si existe en la URL -->
    <?php if (isset($_GET['mensaje'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_GET['tipo'] ?? 'info') ?>" role="alert">
            <?= htmlspecialchars($_GET['mensaje']) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label" style="color: white;">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="nombre_corto" class="form-label" style="color: white;">Nombre Corto</label>
            <input type="text" id="nombre_corto" name="nombre_corto" class="form-control" value="<?= htmlspecialchars($producto['nombre_corto']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label" style="color: white;">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="pvp" class="form-label" style="color: white;">PVP</label>
            <input type="number" id="pvp" name="pvp" class="form-control" step="0.01" value="<?= htmlspecialchars($producto['pvp']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="familia" class="form-label" style="color: white;">Familia</label>
            <select id="familia" name="familia" class="form-control" required>
                <?php foreach ($familias as $familia): ?>
                    <option value="<?= htmlspecialchars($familia['cod']) ?>" <?= $familia['cod'] === $producto['familia'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($familia['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="listado.php" class="btn btn-dark">Atras</a>
    </form>
</body>
</html>
