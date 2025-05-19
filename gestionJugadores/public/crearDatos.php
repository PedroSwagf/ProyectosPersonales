<?php
require_once "../vendor/autoload.php";
require_once "../src/Jugador.php";

use App\Jugador;
use Faker\Factory;
use Philo\Blade\Blade;

$faker = Factory::create('es_ES');

$jugador = new Jugador();

$numJugadores = 10;


for ($i = 0; $i <$numJugadores; $i++) {
    $nombre = $faker->firstName;
    $apellidos = $faker->lastName . ' ' . $faker->lastName;
    do {
        $posicion = $faker->randomElement(['Portero', 'Defensa', 'centrocampista', 'Delantero']);
    } while (empty($posicion));
    $dorsal = $faker->unique()->numberBetween(1, 99);
    $codigo_barras = str_pad($faker->unique()->numberBetween(0, 9999999999999), 13 , '0', STR_PAD_LEFT);
    

    $jugador->insertarJugador($nombre, $apellidos, $posicion, $dorsal, $codigo_barras);
}

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
$blade = new Blade($views, $cache);


$jugadores = $jugador->obtenerJugadores();


echo $blade->view()->make('plantillas.vjugadores', ['jugadores' => $jugadores])->render();