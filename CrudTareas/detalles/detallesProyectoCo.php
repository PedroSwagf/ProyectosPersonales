<?php
  session_start(); 
   //comprobamos que si no existe ninguna sesion nos redirija al index
 if (!isset($_SESSION['inicioSesion'])){
    header('Location: ../index.php');
}

  
  //hacemos la comprobacion del cargo para restringir el acceso a las paginas
    if ($_SESSION['cargo'] == 3){
        header('Location: ../index.php');
    }


    if($_SERVER['REQUEST_METHOD']=='POST'){
        $codigo=$_POST['codigo'];
    }


    include('../plantillas/encabezadoTablas.php');
    include('../modelo/conexion.php');
    include('../modelo/funciones.php');

    $query=$conexion->query("SELECT * FROM proyectos WHERE idProyecto = $codigo");
    $query1=$query->fetchAll(PDO::FETCH_OBJ);

    
?>

<div class="row"> 
    <div class="col-12 d-flex justify-content-center align-items-center" style="margin-top: 100px;">
        <form action="../actualizar/actualizarProyecCoor.php" method="POST"  style="background-color: rgba(58, 61, 60, 0.8); height: 470px; width: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <?php
                foreach ($query1 as $proyectos){
                    echo '<div style="color: white; "class="mb-3">
                            <input type="hidden" class="form-control" id="idProyecto" name="idProyecto" value="'.$proyectos->idProyecto.'">
                        </div>
                        <div style="color: white; "class="mb-3">
                            <label for="nombreProyecto" class="form-label">NombreProyecto</label>
                            <input type="text" class="form-control" id="nombreProyecto" name="nombreProyecto" value="'.$proyectos->nombreProyecto.'">
                         </div>
                         <div style="color: white; "class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="'.$proyectos->descripcion.'">
                        </div>
                        <div style="color: white;" class="mb-3">
                            <label for="idCoord" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="idCoord" name="idCoord" readonly value="'.$proyectos->idCoord.'" >
                        </div>'
                        ;     
                }
            ?>
            <div style="color: white; margin-top: 10px; display: flex; justify-content: space-between;" class="row">
                <div class="col-4">
                    <?php 
                        if($_SESSION['cargo'] == 1) {
                            ?>
                            <button type="button" class="btn btn-outline-dark text-white" onclick="location.href='../indexAdministrador.php'">Atras</button>
                            <?php
                        } else if($_SESSION['cargo'] == 2) {
                            ?><button type="button" class="btn btn-outline-dark text-white" onclick="location.href='../indexCoordinador.php'">Atras</button>
                            <?php
                        }?>
                </div>
                <div class="col-4 text-end"> 
                    <button action="guardar" name="accion" value="Guardar" type="submit" class="btn btn-outline-dark text-white">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
    include('../plantillas/pie.php');
?>