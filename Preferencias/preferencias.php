<?php
    //iniciamos la sesion
    session_start();

    // logica del formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $_SESSION['idioma'] = $_POST['idioma'];
        $_SESSION['perfilPublico'] = $_POST['perfilPublico'];
        $_SESSION['zonaH'] = $_POST['zonaH'];
        $mensaje = 'Preferencias de usuarios guardadas';
    }

    $idioma = isset($_SESSION['idioma']) ? $_SESSION['idioma'] : '';
    $perfilPublico = isset($_SESSION['perfilPublico']) ? $_SESSION['perfilPublico'] : '';
    $zonaH = isset($_SESSION['zonaH']) ? $_SESSION['zonaH'] : '';
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
    <title>Preferencias de Usuario</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <form class="p-4 bg-white rounded shadow" method="POST" action="">
            <h1 class="mb-4 text-center">Preferencias Usuario</h1>

            <!-- Mostrar mensaje si las preferencias se guardaron -->
            <?php if (isset($mensaje)) : ?>
            <div class="alert alert-success text-center">
                <?= $mensaje ?>
            </div>
            <?php endif; ?>

            <!-- Idioma -->
            <div class="mb-3">
                <label for="idioma" class="form-label">
                    <i class="fas fa-language"></i> Idioma
                </label>
                <select name="idioma" id="idioma" class="form-select">
                    <option value="espanol" <?= $idioma === 'espanol' ? 'selected' : '' ?>>Español</option>
                    <option value="ingles" <?= $idioma === 'ingles' ? 'selected' : '' ?>>Inglés</option>
                </select>
            </div>

            <!-- Perfil Público -->
            <div class="mb-3">
                <label for="perfilPublico" class="form-label">
                    <i class="fas fa-user"></i> Perfil Público
                </label>
                <select name="perfilPublico" id="perfilPublico" class="form-select">
                    <option value="si" <?= $perfilPublico === 'si' ? 'selected' : '' ?>>Sí</option>
                    <option value="no" <?= $perfilPublico === 'no' ? 'selected' : '' ?>>No</option>
                </select>
            </div>

            <!-- Zona Horaria -->
            <div class="mb-3">
                <label for="zonaH" class="form-label">
                    <i class="fas fa-clock"></i> Zona Horaria
                </label>
                <select name="zonaH" id="zonaH" class="form-select">
                    <option value="gmt-2" <?= $zonaH === 'gmt-2' ? 'selected' : '' ?>>GMT-2</option>
                    <option value="gmt-1" <?= $zonaH === 'gmt-1' ? 'selected' : '' ?>>GMT-1</option>
                    <option value="gmt" <?= $zonaH === 'gmt' ? 'selected' : '' ?>>GMT</option>
                    <option value="gmt+1" <?= $zonaH === 'gmt+1' ? 'selected' : '' ?>>GMT+1</option>
                    <option value="gmt+2" <?= $zonaH === 'gmt+2' ? 'selected' : '' ?>>GMT+2</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between">
                <a href="mostrar.php" class="btn btn-outline-primary">
                    <i class="fas fa-eye"></i> Mostrar Preferencias
                </a>
                <button type="submit" class="btn btn-outline-success">
                    <i class="fas fa-check"></i> Establecer Preferencias
                </button>
            </div>
        </form>
    </div>
</body>

</html>