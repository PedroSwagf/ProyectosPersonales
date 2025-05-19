<?php
session_start();
 //comprobamos que si no existe ninguna sesion nos redirija al index
 if (!isset($_SESSION['inicioSesion'])){
    header('Location: ../index.php');
    exit();
}

//hacemos la comprobacion del cargo para restringir el acceso a las paginas
if ($_SESSION['cargo'] != 1){
    session_destroy();
    header('Location: ../index.php');
    exit();
}

include('../modelo/conexion.php');
    
// Verificamos si se ha enviado el formulario
if (isset($_POST['idProyecto'])){
    $codigo = $_POST['idProyecto'];

    // Preparamos la consulta SQL usando sentencias preparadas
    $stmt = $conexion->prepare("DELETE FROM proyectos WHERE idProyecto = ?");
    $stmt->execute([$codigo]);
    setcookie('proyectoEliminado_msg', 'Proyecto Eliminado Exitosamente', time() + 3600, '/');
} 

header("Location: ../tablas/tablaProyectos.php");
?>