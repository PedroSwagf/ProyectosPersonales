<?php
session_start();
 //comprobamos que si no existe ninguna sesion nos redirija al index
 if (!isset($_SESSION['inicioSesion'])){
    header('Location: ../index.php');
    exit();
}

//hacemos la comprobacion del cargo para restringir el acceso a la pagina, a la cual solo puede acceder el administrador
if ($_SESSION['cargo'] != 1){
    session_destroy();
    header('Location: ../index.php');
    exit();
}

include('../modelo/conexion.php');
include('../modelo/funciones.php');

 

if ($_POST['accion'] == 'Guardar'){
    $nombreUsuario = $_POST['nombreUsuario'];
    $contraseña = $_POST['contraseña'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $cargo = $_POST['idCargo'];
    
 // Ciframos la contraseña antes de insertarla en la base de datos
 $contraseñaCifrada = password_hash($contraseña, PASSWORD_BCRYPT);
    
 // Preparamos la consulta SQL usando sentencias preparadas
 $stmt = $conexion->prepare("INSERT INTO usuarios (nombreUsuario, contraseña, nombre, apellidos, idCargo) VALUES (?, ?, ?, ?, ?)");
 $stmt->execute([$nombreUsuario, $contraseñaCifrada, $nombre, $apellidos, $cargo]);
 
 // Establecemos una cookie para indicar que el usuario fue registrado exitosamente
 setcookie('userRegistrado_msg', 'Usuario Registrado Exitosamente', time() + 3600, '/');
}

// Redireccionamos al usuario a la página de tabla de usuarios
header("Location: ../tablas/tablaUsuarios.php");
exit(); // Añadir exit para evitar ejecución adicional
?>