<?php
    session_start();
    //comprobamos que si no existe ninguna sesion nos redirija al index
    if (!isset($_SESSION['inicioSesion'])){
        header('Location: index.php');
    }

    //hacemos la comprobacion del cargo para restringir el acceso a la pagina, ya que a este solo puede acceder el administrador
    if ($_SESSION['cargo'] != 1){
        session_destroy();
        header('Location: index.php');
    }

    $_SESSION['inicioSesion'] = 'nombreUsuario';


    include('plantillas/encabezado.php');
    include('modelo/conexion.php');

    //mostramos el mensaje de bienvenida
    if(isset($_COOKIE['bienvenida_msg'])) {
        echo '<div class="alert alert-danger text-center" role="alert">' . $_COOKIE['bienvenida_msg'] . '</div>';
            setcookie('bienvenida_msg', '', time() - 60, '/');
    }
?>



<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="margin-top: 300px;">
            <form method="POST" action="comprobarLogin.php" style="background-color: rgba(58, 61, 60, 0.8); height: 300px; width: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <h1 style="text-align: center; color: white;">Administrar:</h1>
                <div class="row">
                    <div class="col-4" style="margin-top: 10px; text-align: center;">
                        <button type="button" class="btn btn-dark" onclick="window.location.href='tablas/tablaTareas.php'">Tareas</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4" style="margin-top: 25px; text-align: center;">
                        <button type="button" class="btn btn-dark" onclick="window.location.href='tablas/tablaProyectos.php'">Proyectos</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4" style="margin-top: 25px; text-align: center;">
                        <button type="button" class="btn btn-dark" onclick="window.location.href='tablas/tablaUsuarios.php'">Usuarios</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    
<?php
    //print_r ($_SESSION);
    include('plantillas/pie.php');
    $conexion=null;
?>