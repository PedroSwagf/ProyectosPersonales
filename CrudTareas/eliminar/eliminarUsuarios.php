<?php
session_start();

// Comprobamos si existe una sesión iniciada, si no, redirigimos al index
if (!isset($_SESSION['inicioSesion'])){
    header('Location: ../index.php');
    exit(); // Añadimos exit para asegurar que el script se detenga aquí
}

// Verificamos el cargo del usuario para restringir el acceso
if ($_SESSION['cargo'] != 1){
    session_destroy();
    header('Location: ../index.php');
    exit(); // Añadimos exit para asegurar que el script se detenga aquí
}

// Incluimos el archivo de conexión a la base de datos
include('../modelo/conexion.php');

// Verificamos si se ha enviado el formulario con el nombre de usuario
if (isset($_POST['nombreUsuario'])) {
    // Preparamos la consulta SQL con un marcador de posición
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE nombreUsuario = :nombreUsuario");
    // Enlazamos el parámetro con el valor del nombre de usuario
    $stmt->bindParam(':nombreUsuario', $_POST['nombreUsuario']);
    // Ejecutamos la consulta
    $stmt->execute();
    
    // Establecemos una cookie para indicar que el usuario fue eliminado
    setcookie('userEliminado_msg', 'Usuario Eliminado Exitosamente', time() + 3600, '/');
} else {
    setcookie('userNoExis_msg', 'El usuario no existe', time() + 3600, '/');
    
}

// Redirigimos al usuario a la página de tabla de usuarios
header('Location: ../tablas/tablaUsuarios.php');
exit(); 
?>
