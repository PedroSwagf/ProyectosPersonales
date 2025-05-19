<?php
session_start();

 //comprobamos que si no existe ninguna sesion nos redirija al index
 if (!isset($_SESSION['inicioSesion'])){
    header('Location: ../index.php');
}

//hacemos la comprobacion del cargo para restringir el acceso a la pagina, en esta pagina le restrinjimos el acceso al personal
if ($_SESSION['cargo'] == 3){
    session_destroy();
    header('Location: ../index.php');
}

include('../modelo/conexion.php');
include('../modelo/funciones.php');

if ($_POST['accion'] == 'Guardar'){
    $nombre = $_POST['nombreProyecto'];
    $descripcion = $_POST['descripcion'];
    $coord = $_POST['idCoord'];

    //verificamos si el usuario es coordinador y existe!!

    $verificarCoor = "SELECT * FROM usuarios WHERE idCargo = 2 AND nombreUsuario = '$coord' ";
    $verificarCoor2 = $conexion->query($verificarCoor);
    $result = $verificarCoor2->fetch(PDO::FETCH_ASSOC);
    if($result == ''){
        //guardamos el error en una sesion y se lo eviamos a la tablaproyectos
        $_SESSION['error_message'] = "El Coordinador no existe";
        header("Location: ../indexCoordinador.php");
    } else {
        $modificar = "INSERT INTO proyectos (nombreProyecto, descripcion, idCoord)
              VALUES ( '$nombre','$descripcion', '$coord')";
        $crear = $conexion->query($modificar);
        header("Location: ../indexCoordinador.php");
    }
}
?>