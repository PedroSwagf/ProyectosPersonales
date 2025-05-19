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
    
if (isset($_POST['idTarea'])) {
    $codigo = $_POST['idTarea'];

    //preparamos la consulta para prevenir inyeccion de sql
    $borrartareas = $conexion->prepare("DELETE FROM tareas WHERE idTarea = :idTarea");

    // vinculamos la variable a la consulta preparada
    $borrartareas->bindParam(":idTarea", $codigo, PDO::PARAM_INT);
    $borrartareas->execute();

}else {
    echo "la tarea no existe";
    
}

header("Location: ../tablas/tablaTareasProyectos.php");
?>
