<?php
session_start();
include('plantillas/encabezado.php');
include('modelo/conexion.php');
include('modelo/funciones.php');

//verificamos si existe la sesion y si no existe redirijo al login
if (!isset($_SESSION['inicioSesion'])) {
    header('Location: login.php');
    exit();
} else {
    $nombre = $_SESSION['inicioSesion'];
    $cargo = verificarCargo($conexion, $nombre);
    if ($cargo == false) {
        // Manejar el caso en que verificarCargo falla o devuelve un valor inesperado
        header('Location: login.php');
        exit();
    }
    
    $_SESSION['cargo'] = $cargo;
    switch ($cargo) {
        case 1: //cargar pagina de administrador
            header('Location: indexAdministrador.php');
            exit();
        break;

        case 2: //cargar pagina de coordinador
            header('Location: indexCoordinador.php');
            exit();
        break;

        case 3: //cargar pagina de personal
            header('Location: indexPersonal.php');
            exit();
        break;

        default:
            // Manejar el caso en que $cargo no coincide con ninguno de los casos especificados
            header('Location: login.php');
            exit();
    }
}

include('plantillas/pie.php');

?>