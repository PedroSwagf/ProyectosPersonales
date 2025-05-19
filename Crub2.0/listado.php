<?php
/**requimos el archivo de conexion de la base de datos */
require 'conexion.php';

/** ahora realizamos la consulta para visualizar la lista de productos */
$stmt = $pdo->query('Select * from productos');
$productos = $stmt->fetchall(PDO::FETCH_ASSOC);

/**mostrar los msj */

$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : null;
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'info';// este seria el tipo por defecto

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
    <title>Tarea_UD04</title>
</head>
<body class="container mt-4">
    <h1>Listado de productos</h1>

    <!-- aqui mostramos el mensaje -->
     <?php if ($mensaje): ?>
        <div class="alert alert-<?= htmlspecialchars($tipo) ?>" role="alert" style="text-align: center;">
            <?= htmlspecialchars($mensaje) ?>
        </div>
     <?php endif; ?>
    <a href="crear.php" class="btn btn-outline-dark mb-3">Agregar Producto</a>
    <table class="table table-dark">
        <thead>
            <tr>
                <th></th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>PVP</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //**usamos foreach para recorrer las filas de la tabla y sacar los datos */
                foreach ($productos as $producto): 
            ?>
            <tr>
                <!-- declaromos los botones y el cuerpo de la tabla
                 usamos urlencode para codificar el valor del producto que pasamos por url -->
                <td><a href="detalle.php?id=<?= urlencode($producto['id']) ?>" class="btn btn-outline-success">Ver Detalles</a></td>
                <td><?= htmlspecialchars($producto['id']) ?></td>
                <td><?= htmlspecialchars($producto['nombre']) ?></td>
                <td><?= htmlspecialchars($producto['pvp']) ?>$</td>
                <td>
                    <a href="update.php?id=<?= urlencode($producto['id']) ?>" class="btn btn-outline-warning">Actualizar</a>
                    <form action="borrar.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">
                        <button type="submit" class="btn btn-outline-danger">Borrar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <footer>@Pedro Fernandez</footer>
</body>
</html>