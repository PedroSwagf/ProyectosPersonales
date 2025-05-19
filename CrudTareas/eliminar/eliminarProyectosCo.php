<?php
session_start();
 //comprobamos que si no existe ninguna sesion nos redirija al index
 if (!isset($_SESSION['inicioSesion'])){
    header('Location: ../index.php');
}

//hacemos la comprobacion del cargo para restringir el acceso a las paginas
if ($_SESSION['cargo'] == 3){
    session_destroy();
    header('Location: ../index.php');
}

include('../modelo/conexion.php');
    
if (isset($_POST['idProyecto'])) {
    $codigo = $_POST['idProyecto'];

$borrarProyectos = "DELETE FROM proyectos WHERE idProyecto = '$codigo'";

$querydel=$conexion->query($borrarProyectos);

}else {
    echo "El proyecto no existe";
    
}

header("Location: ../indexCoordinador.php");
?>