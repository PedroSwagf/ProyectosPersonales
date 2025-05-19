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

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $codigo=$_POST['codigo'];
    }


    include('../plantillas/encabezadoTablas.php');
    include('../modelo/conexion.php');
    include('../modelo/funciones.php');

    $query=$conexion->query("SELECT * FROM usuarios WHERE nombreUsuario = '$codigo'");
    $query1=$query->fetchAll(PDO::FETCH_OBJ);

    
?>

<div class="row"> 
    
    <div class="col-12 d-flex justify-content-center align-items-center" style="margin-top: 100px;">
        <form action="..\actualizar\actualizarUser.php" method="POST"  style="background-color: rgba(58, 61, 60, 0.8); height: 600px; width: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <?php
                foreach ($query1 as $usuarios){
                    echo '<div style="color: white; "class="mb-3">
                            <label for="nombreUsuario" class="form-label">Nombre Login</label>
                            <input type="text" class="form-control" id="nombreUsuario" readonly name="nombreUsuario" value="'.$usuarios->nombreUsuario.'" >
                         </div>
                                       
                        <div style="color: white; "class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="text" class="form-control" id="contraseña" readonly name="contraseña" value="'.$usuarios->contraseña.'">
                        </div>
                        <div style="color: white;" class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="'.$usuarios->nombre.'" >
                        </div>
                        <div style="color: white;" class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="'.$usuarios->apellidos.'" >
                        </div>
                        <div style="color: white; "class="mb-3">
                            <label for="idCargo" class="form-label">idCargo</label>
                            <input type="number" class="form-control" id="idCargo" name="idCargo" value="'.$usuarios->idCargo.'">
                        </div>'

                        ; 
                    
                    
                    
                }
            ?>
            
            <div style="color: white; margin-top: 10px; display: flex; justify-content: space-between;" class="row">
                <div class="col-4">
                    <button type="button" class="btn btn-outline-dark text-white" onclick="location.href='../tablas/tablaUsuarios.php'">Atras</button>
                </div>
                <div class="col-4 "> 
                    <button action="guardar" name="accion" value="Guardar" type="submit" class="btn btn-outline-dark text-white">Guardar</button>
                </div>
            </div>
        </form>
    </div>
    
</div>


<?php
    include('../plantillas/pie.php');
?>