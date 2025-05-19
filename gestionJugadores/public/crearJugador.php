<?php
require_once "../vendor/autoload.php";
require_once "../src/Jugador.php";

use App\Jugador;
use Philo\Blade\Blade;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $dorsal = $_POST['dorsal'];
    $posicion = $_POST['posicion'];
    $codigo_barras = $_POST['codigo_barras'];


    if (empty($nombre) || empty($apellidos)) {
        die("El nombre y los apellidos son obligatorios.");
    }

    $jugador = new Jugador();
    if ($jugador->dorsalExiste($dorsal)) {
        die("El dorsal ya está asignado. Por favor, elige otro número.");
    }

    
    if ($jugador->codigoBarrasExiste($codigo_barras)) {
        die("El código de barras ya está en uso. Por favor, genera uno nuevo.");
    }

    $ruta_imagen = 'barcodes/' . $codigo_barras . '.jpg';
    try {
        $jugador->insertarJugador($nombre, $apellidos, $posicion, $dorsal, $codigo_barras, $ruta_imagen);
        $jugadores = $jugador->obtenerJugadores();        
        $views = __DIR__ . '/../views';
        $cache = __DIR__ . '/../cache';
        $blade = new Blade($views, $cache);        
        echo $blade->view()->make('plantillas.vjugadores', ['jugadores' => $jugadores])->render();
    } catch (Exception $e) {
        die("Hubo un error al crear el jugador: " . $e->getMessage());
    }
}