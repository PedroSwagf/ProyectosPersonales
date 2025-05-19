<?php
    session_start();
    include('plantillas/encabezado.php');
    include('modelo/conexion.php');

    if (isset($_SESSION["nombreUsuario"])) {
        unset($_SESSION["nombreUsuario"]);
    }



    if(isset($_COOKIE['error_msg'])) {
        echo '<div class="alert alert-danger text-center" role="alert">' . $_COOKIE['error_msg'] . '</div>';
            setcookie('error_msg', '', time() - 3600, '/');
    }

?>

<div class="container">
    <div class="row" >
        <div class="col-12 d-flex justify-content-center align-items-center" style="margin-top: 300px;">   
        <form method="POST" action="comprobarLogin.php" style="background-color: rgba(58, 61, 60, 0.8); height: 350px; width: 340px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3 text-center">
                                <h1 for="inicion de sesion" class="form-h1" style="color:white;">Inicio de Sesion</h1>
                            </div>
                            <div class="mb-3 text-center">
                                <h5 for="nombre" class="form-h1" style="color:white;">Usuario:</h5>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Introduce un usuario">
                            </div>
                            <div class="mb-3 text-center">
                                <h5 for="contraseña" class="form-h1" style="color: white;">Contraseña:</h5>
                                <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Introduce una contraseña" required>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content" style="margin: 20px" >
                        <div class="col-6 d-grid-2 gap-5 text-center" >
                            <button  name="enviar" type="submit" class="btn btn-dark text-nowrap">Iniciar Sesion</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>

<?php
   
?>


<?php
    include('plantillas/pie.php');
    $conexion=null;
?>