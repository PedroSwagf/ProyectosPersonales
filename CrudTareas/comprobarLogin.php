<?php
session_start();
//a esta pagina directamen no se puede acceder
include('modelo/conexion.php');
include('modelo/funciones.php');

if (isset($_POST['enviar'])) {
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];
    
    $contraseñaCifrada = contraseñaCifrada($conexion, $nombre);
//echo $contraseñaCifrada. " esta es al primera";


    if (password_verify($contraseña, $contraseñaCifrada)) {
        
        $_SESSION['inicioSesion'] = $nombre;

        $cargo = verificarCargo($conexion, $nombre);
        $_SESSION['cargo'] = $cargo;

        switch ($cargo) {
            case 1: // Administrador
                header('Location: indexAdministrador.php');
                setcookie('bienvenida_msg','Bienvenido:'.' '.$_SESSION['inicioSesion'],time()+5);
                exit();
            case 2: // Coordinador
                    header('Location: indexCoordinador.php');
                    setcookie('bienvenida_msg','Bienvenido:'.' '.$_SESSION['inicioSesion'],time()+5);
                    exit();
             
            case 3: // Personal
                header('Location: indexPersonal.php');
                setcookie('bienvenida_msg','Bienvenido:'.' '.$_SESSION['inicioSesion'],time()+5);
                exit();
            default:
                header('Location: index.php');
                exit();
        }
    }

        } else {
            //con esta comprobacion si la sesion no esta iniciada no nos deja entra directamente a ella
            session_destroy();
            header('Location: login.php');
            setcookie('error_msg','El usuario no esta registrado', time()+ 200,'/');
            exit();
        }
        //termina aqui
        header('Location: login.php');
        setcookie('error_msg', 'Contraseña incorrecta', time() + 200, '/');
        exit();

?>
