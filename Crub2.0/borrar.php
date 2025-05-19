<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar el ID del producto
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        header('Location: listado.php?mensaje=ID no válido');
        exit;
    }

    $id = $_POST['id'];

    try {
        // Preparamos la consulta
        $stmt = $pdo->prepare('DELETE FROM productos WHERE id = ?');
        $stmt->execute([$id]);

        // Mensaje de éxito o fallo
        if ($stmt->rowCount() > 0) {
            $mensaje = "El producto con ID $id ha sido eliminado exitosamente.";
            $tipo = 'success'; // Para mostrar mensajes de éxito
        } else {
            $mensaje = "No se encontró un producto con ID $id.";
            $tipo = 'warning'; // Para advertencias
        }
    } catch (PDOException $e) {
        $mensaje = 'Error al eliminar el producto: ' . $e->getMessage();
        $tipo = 'danger'; // Para errores
    }

    // Redirigir con mensaje
    header("Location: listado.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo);
    exit;
} else {
    header('Location: listado.php');
    exit;
}
?>
