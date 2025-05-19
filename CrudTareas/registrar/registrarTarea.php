<?php
session_start();
 //comprobamos que si no existe ninguna sesion nos redirija al index
 if (!isset($_SESSION['inicioSesion'])){
    header('Location: ../index.php');
}

//hacemos la comprobacion del cargo para restringir el acceso a la pagina,solo accede administrador
if ($_SESSION['cargo'] != 1){
    session_destroy();
    header('Location: ../index.php');
}

include('../modelo/conexion.php');
include('../modelo/funciones.php');

if ($_POST['accion'] == 'Guardar'){
    $nombre = $_POST['nombre'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaEntrega = $_POST['fechaEntrega'];
    $descripcion = $_POST['descripcion'];
    $usuario = $_POST['nombreUsuario'];
    $proyecto = $_POST['idProyecto'];

    //echo $nombre, $fechaInicio ,$fechaEntrega, $descripcion,$usuario,$proyecto;
  
        $resgistrarTarear = "INSERT INTO tareas (nombre, fechaInicio, fechaEntrega, descripcion, idProyecto)
        VALUES ('$nombre', '$fechaInicio', '$fechaEntrega', '$descripcion', '$proyecto')";

        $crear = $conexion->query($resgistrarTarear);

        // hacemos consulta SQL y obtenemos el ultimo idTarea que se ingreso
        $sql = "SELECT idTarea FROM tareas ORDER BY idTarea DESC LIMIT 1";
        $result = $conexion->query($sql);

        // Aseguramos de que la consulta devuelve un resultado
        if ($result->rowCount() > 0) {
        // Obtenemos el idTarea del último registro insertado
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $idTarea = $row['idTarea'];

        $registarUserTarea = "INSERT INTO usuariosTarea (idUsuario,idTarea)
                    VALUES ('$usuario', '$idTarea')";

        $crear2 = $conexion->query($registarUserTarea);
        } else {
       
        echo "No se encontró el idTarea.";
        }
} 
header("Location: ../tablas/tablaTareas.php");
?>