<?php
require_once "../vendor/autoload.php";
require_once "../src/Jugador.php";

use Philo\Blade\Blade;
use App\Jugador;

$jugador = new Jugador();
$jugadores = $jugador->obtenerJugadores();

if(empty($jugadores)) {
    header("Location: instalacion.php");
    exit();
}

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';

$blade = new Blade($views, $cache);

echo $blade->view()->make('plantillas.vjugadores', ['jugadores' => $jugadores])->render();