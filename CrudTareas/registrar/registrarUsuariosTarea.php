<?php
session_start();
 //comprobamos que si no existe ninguna sesion nos redirija al index
 if (!isset($_SESSION['inicioSesion'])){
    header('Location: ../index.php');
}

//hacemos la comprobacion del cargo para restringir el acceso a la pagina, solo le damos accesos al administrador
if ($_SESSION['cargo'] == 3){
    session_destroy();
    header('Location: ../index.php');
}

include('../modelo/conexion.php');
include('../modelo/funciones.php');

if ($_POST['accion'] == 'Guardar'){
    $idTarea = $_POST['idTarea'];
    $nombreUsuario = $_POST['nombreUsuario'];
    
    // Verificar si el idTarea existe en la tabla tareas
    $verificarTarea = $conexion->prepare("SELECT idTarea FROM tareas WHERE idTarea = :idTarea");
    $verificarTarea->bindParam(':idTarea', $idTarea);
    $verificarTarea->execute();
    
    if ($verificarTarea->rowCount() == 0) {
        // El idTarea no existe en la tabla tareas, manejar este caso
        echo "El idTarea proporcionado no existe en la tabla tareas.";
    } else {
        // El idTarea existe, proceder con la inserción
        if (usuarioAsociadoTarea($conexion,$idTarea, $nombreUsuario)){ 
            setcookie('usuarioExiste_msg', 'El Usuario Ya Existe En La Tarea', time() + 3600, '/');
        } else {
            $registrarUT = "INSERT INTO usuariosTarea (idUsuario,idTarea)
                            VALUES ('$nombreUsuario','$idTarea')";
            $crearUT = $conexion->query($registrarUT);
            setcookie('usuarioRegistrado_msg', 'Usuario Registrado Exitosamente En La Tarea', time() + 3600, '/');
        }
    }
    
}

if ($_POST['accion'] == 'Eliminar'){
    $idTarea = $_POST['idTarea'];
    $nombreUsuario = $_POST['nombreUsuario'];
    
    // Verificar si el idTarea existe en la tabla tareas
    $verificarTarea = $conexion->prepare("SELECT idTarea FROM tareas WHERE idTarea = :idTarea");
    $verificarTarea->bindParam(':idTarea', $idTarea);
    $verificarTarea->execute();
    
    if ($verificarTarea->rowCount() == 0) {
        // El idTarea no existe en la tabla tareas, manejar este caso
        echo "El idTarea proporcionado no existe en la tabla tareas.";
    } else {
        // El idTarea existe, proceder con la eliminación
        if (usuarioAsociadoTarea($conexion,$idTarea, $nombreUsuario)){      
            $registrarUT = "DELETE FROM usuariosTarea WHERE idUsuario = :nombreUsuario AND idTarea = :idTarea";
            $crearUT = $conexion->prepare($registrarUT);
            $crearUT->bindParam(':nombreUsuario', $nombreUsuario);
            $crearUT->bindParam(':idTarea', $idTarea);
            $crearUT->execute();
            setcookie('usuarioEliminado_msg', 'Usuario Eliminado Exitosamente en la Tarea', time() + 3600, '/');
            
        }
    }
    
}

$cargo = $_SESSION['cargo']  ;

    switch ($cargo) {
        case 1: // Administrador
            header('Location: ..\tablas\tablaTareas.php');
            exit();
        case 2: // Coordinador
            header('Location: ..\tablas\tablaTareasProyectos.php');
            exit();
    }
?>