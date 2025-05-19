<?php
require_once "../vendor/autoload.php";
require_once "../src/Jugador.php";

use App\Jugador;
use Philo\Blade\Blade;
use Milon\Barcode\DNS1D;

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
$blade = new Blade($views, $cache);

$jugador = new Jugador();


function calcularDigitoControl($codigoBase) {
    $sumaImpares = 0;
    $sumaPares = 0;

    for ($i = 0; $i < 12; $i++) {
        $digito = intval($codigoBase[$i]);
        if ($i % 2 == 0) {
            $sumaImpares += $digito;
        } else {
            $sumaPares += $digito;
        }
    }

    $sumaTotal = $sumaImpares + ($sumaPares * 3);
    $modulo = $sumaTotal % 10;
    return $modulo === 0 ? 0 : 10 - $modulo;
}


do {
    $codigoBase = str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
    $codigo = $codigoBase . calcularDigitoControl($codigoBase);
} while ($jugador->codigoBarrasExiste($codigo));


$folderPath = __DIR__ . '/../public/barcodes/';
if (!file_exists($folderPath)) {
    mkdir($folderPath, 0777, true);
}


$imagePath = $folderPath . $codigo . '.jpg';
$barcode = new DNS1D();
$barcodePNG = base64_decode($barcode->getBarcodePNG($codigo, 'EAN13'));

$image = imagecreatefromstring($barcodePNG);
imagejpeg($image, $imagePath, 100);
imagedestroy($image);


echo $blade->view()->make('plantillas.vcrear', [
    'codigo_barras' => $codigo,
    'imagen' => $imagePath
])->render();