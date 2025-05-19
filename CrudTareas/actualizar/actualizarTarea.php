<?php
session_start();
// Comprobamos que si no existe ninguna sesión nos redirija al index
if (!isset($_SESSION['inicioSesion'])){
    header('Location: ../index.php');
}

// Hacemos la comprobación del cargo para restringir el acceso a las páginas
if ($_SESSION['cargo'] != 1){
    session_destroy();
    header('Location: ../index.php');
}

include('../modelo/conexion.php');
include('../modelo/funciones.php');

if ($_POST['accion'] == 'Guardar'){
    $idTarea = $_POST['idTarea'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaEntrega = $_POST['fechaEntrega'];
    $idProyecto = $_POST['idProyecto'];
    $usuario = $_POST['idUsuario'];

    // Verificamos si el usuario es de personal y existe
    $verificarUser = $conexion->prepare("SELECT * FROM usuarios WHERE idCargo = 3 AND nombreUsuario = :usuario");
    $verificarUser->bindParam(':usuario', $usuario);
    $verificarUser->execute();
    $result = $verificarUser->fetch(PDO::FETCH_ASSOC);
    if($result == ''){
        // Guardamos el error en una sesión y se lo enviamos a la tabla de proyectos
        $_SESSION['error_message'] = "El Usuario no existe";
        header("Location: ../tablas/tablaTareas.php");
    } else {
        // Actualizamos la tarea esto lo hacemos para prevenir la inyeccion sql en mi codigo
        // usando el bindParam indicamos que los valores son datos literales y no como parte de la consulta sql
        $actualizarTarea = $conexion->prepare("UPDATE tareas SET nombre = :nombre, descripcion = :descripcion, fechaInicio = :fechaInicio, fechaEntrega = :fechaEntrega, idProyecto = :idProyecto WHERE idTarea = :idTarea");
        $actualizarTarea->bindParam(':nombre', $nombre);
        $actualizarTarea->bindParam(':descripcion', $descripcion);
        $actualizarTarea->bindParam(':fechaInicio', $fechaInicio);
        $actualizarTarea->bindParam(':fechaEntrega', $fechaEntrega);
        $actualizarTarea->bindParam(':idProyecto', $idProyecto);
        $actualizarTarea->bindParam(':idTarea', $idTarea);
        $actualizarTarea->execute();

        // Verificamos la tabla usuariosTarea
        $sql = $conexion->prepare("SELECT * FROM usuariosTarea WHERE idUsuario = :usuario AND idTarea = :idTarea");
        $sql->bindParam(':usuario', $usuario);
        $sql->bindParam(':idTarea', $idTarea);
        $sql->execute();

        // Verifica si el nuevo idUsuario ya está asociado con el idTarea
        $checkExisting = $conexion->prepare("SELECT * FROM usuariosTarea WHERE idUsuario = :usuario AND idTarea = :idTarea");
        $checkExisting->bindParam(':usuario', $usuario);
        $checkExisting->bindParam(':idTarea', $idTarea);
        $checkExisting->execute();

        // Si el nuevo idUsuario no está ya asociado con el idTarea, procede con la actualización
        if ($checkExisting->rowCount() == 0) {
            $actualizarTarea2 = $conexion->prepare("UPDATE usuariosTarea SET idUsuario = :usuario WHERE idTarea = :idTarea");
            $actualizarTarea2->bindParam(':usuario', $usuario);
            $actualizarTarea2->bindParam(':idTarea', $idTarea);
            $actualizarTarea2->execute();
        }
    }
} else {
    echo "El usuario no existe";
}

header('Location: ../tablas/tablaTareas.php');
?>


