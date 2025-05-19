<?php
session_start();
$mensaje = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'borrar') {
        
        if (isset($_SESSION['idioma']) || isset($_SESSION['perfilPublico']) || isset($_SESSION['zonaH'])) {
            session_unset(); 
            $mensaje = 'Preferencias borradas.';
        } else {
            $mensaje = 'No hay preferencias para borrar.';
        }
    }
}

// Obtener las preferencias almacenadas
$idioma = isset($_SESSION['idioma']) ? $_SESSION['idioma'] : 'No establecido';
$perfilPublico = isset($_SESSION['perfilPublico']) ? $_SESSION['perfilPublico'] : 'No establecido';
$zonaH = isset($_SESSION['zonaH']) ? $_SESSION['zonaH'] : 'No establecido';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <title>Mostrar Preferencias</title>
</head>

<body class="bg-dark">
    <div class="container mt-5">
        <div class="p-4 bg-success rounded shadow">
            <?php if (!empty($mensaje)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= htmlspecialchars($mensaje) ?>
            </div>
            <?php endif; ?>

            <h1 class="mb-4 text-center"><i class="fas fa-user">Preferencias Guardadas</i></h1>
            <p><strong>Idioma:</strong> <?= htmlspecialchars($idioma) ?></p>
            <p><strong>Perfil Público:</strong> <?= htmlspecialchars($perfilPublico) ?></p>
            <p><strong>Zona Horaria:</strong> <?= htmlspecialchars($zonaH) ?></p>

            <a href="preferencias.php" class="btn btn-primary">
                <i class="fas fa-eye"></i> Establecer Preferencias
            </a>

            <!-- Formulario para Borrar -->
            <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="d-inline-block">
                <input type="hidden" name="accion" value="borrar">
                <button type="submit" class="btn btn-danger">Borrar</button>
            </form>

        </div>
    </div>
</body>

</html>