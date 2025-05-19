<?php
require_once "../vendor/autoload.php";

use Philo\Blade\Blade;

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
$blade = new Blade($views, $cache);

$codigo_barras = $_GET['codigo_barras'] ?? '';
$imagen = $_GET['imagen'] ?? '';
$ruta_imagen = 'barcodes/' . $imagen;

echo $blade->view()->make('plantillas.vcrear', [
    'codigo_barras' => $codigo_barras,
    'imagen' => $imagen,
    'ruta_imagen' => $ruta_imagen
])->render();