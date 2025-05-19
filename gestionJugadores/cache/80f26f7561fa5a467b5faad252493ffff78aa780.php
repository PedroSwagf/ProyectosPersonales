<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Crear Jugador</title>
    <style>
    body {
        background-color: #FF7043;
        font-family: Arial, sans-serif;
        text-align: center;
        color: #fff;
    }

    form {
        margin: 20px auto;
        padding: 20px;
        background: white;
        color: black;
        border-radius: 10px;
        max-width: 600px;
    }

    input,
    select,
    button {
        margin: 10px 0;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    button {
        cursor: pointer;
    }

    img {
        width: 200px;
        heigth: 200px
    }
    </style>
</head>

<body>
    <h1>Crear Jugador</h1>
    <form action="crearJugador.php" method="POST">
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div>
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" required>
        </div>
        <div>
            <label for="dorsal">Dorsal</label>
            <input type="number" name="dorsal" id="dorsal" required>
        </div>
        <div>
            <label for="posicion">Posición</label>
            <select name="posicion" id="posicion">
                <option value="Portero">Portero</option>
                <option value="Defensa">Defensa</option>
                <option value="Centrocampista">Centrocampista</option>
                <option value="Delantero">Delantero</option>
            </select>
        </div>
        <div>
            <label for="codigo_barras">Código de Barras</label>
            <input type="text" name="codigo_barras" id="codigo_barras" class="form-control" value="<?php echo e($codigo_barras); ?>"
                readonly>
            <a href="generarCode.php" class="btn btn-dark">Generar Barcode</a>
        </div>
        <?php if($imagen): ?>
        <div class="mt-3">
            <p>Vista del código de barras</p>
            <img src="<?php echo e($ruta_imagen); ?>" alt="codigo de barras" class="img-fluid">

        </div>
        <?php endif; ?>

        <button type=" submit" class="btn btn-primary">Crear</button>
        <button type="reset" class=" btn btn-warning"">Limpiar</button>
        <a href=" index.php" class="btn btn-info">Volver</a>
    </form>
</body>

</html>