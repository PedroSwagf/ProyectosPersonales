<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Lista de Jugadores</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #ff8a65
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #f4f4f4;
    }

    .table-dark th,
    .table-dark td {
        background-color: #333;
        color: #fff;
    }

    h1 {
        text-align: center;
    }

    img {
        width: 200px;
        heigth: 200px
    }
    </style>
</head>

<body>
    <h1>Lista de Jugadores</h1>

    <a href="fcrear.php" class="btn btn-success">Crear Jugador</a>

    <table class=" table-dark">
        <thead>
            <tr>
                <th>Nombre Completo</th>
                <th>Posición</th>
                <th>Dorsal</th>
                <th>Código de Barras</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jugadores as $jugador): ?>
            <tr>
                <td><?= $jugador['nombre'] . ' ' . $jugador['apellidos'] ?></td>
                <td><?= $jugador['posicion'] ?></td>
                <td><?= $jugador['dorsal'] ?></td>
                <td>
                    <img src="<?= $jugador['ruta_imagen'] ?>" alt="Código de Barras">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>