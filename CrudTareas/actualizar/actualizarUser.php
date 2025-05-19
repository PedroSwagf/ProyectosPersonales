<?php
session_start();
 //comprobamos que si no existe ninguna sesion nos redirija al index
 if (!isset($_SESSION['inicioSesion'])){
    header('Location: ../index.php');
}

//hacemos la comprobacion del cargo para restringir el acceso a las paginas
if ($_SESSION['cargo'] != 1){
    session_destroy();
    header('Location: ../index.php');
}

include('../modelo/conexion.php');
    
if (isset($_POST['nombreUsuario'])) {
    $codigo = $_POST['nombreUsuario'];
    $contraseña = $_POST['contraseña'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $cargo = $_POST['idCargo'];

    // Cifrar la contraseña antes de insertarla en la base de datos
    $contraseñaCifrada = password_hash($_POST['contraseña'],  PASSWORD_BCRYPT);

$actualizarUser =   "UPDATE usuarios 
                    SET contraseña = '$contraseñaCifrada',
                    nombre = '$nombre',
                    apellidos = '$apellidos',
                    idCargo = '$cargo'
                    WHERE nombreUsuario = '$codigo' ";

$updateUser=$conexion->query($actualizarUser);

}else {
    echo "El usuario no existe";
    
}

header('Location: ../tablas/tablaUsuarios.php');
?>