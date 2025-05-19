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
        $codigo=$_POST['idTarea'];
    }


    include('../plantillas/encabezadoTablas.php');
    include('../modelo/conexion.php');
    include('../modelo/funciones.php');

    $query=$conexion->query("SELECT idTarea,nombre,descripcion,fechaInicio,fechaEntrega,idProyecto FROM tareas WHERE idTarea = $codigo");
    $query1=$query->fetchAll(PDO::FETCH_OBJ);

    $sql = $conexion->query("SELECT idUsuario FROM usuariosTarea WHERE idTarea = $codigo");
    $sql2 = $sql->fetchAll(PDO::FETCH_OBJ);
    
?>

<div class="row"> 
    
    <div class="col-12 d-flex justify-content-center align-items-center" style="margin-top: 100px;">
        <form action="..\actualizar\actualizarTarea.php" method="POST"  style="background-color: rgba(58, 61, 60, 0.8); height: auto; width: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px; ">
            <?php
                foreach ($query1 as $tareas){
                    echo '<div style="color: white; "class="mb-3">
                            <input type="hidden" class="form-control" id="idTarea" name="idTarea" value="'.$tareas->idTarea.'">
                          </div>
                        <div style="color: white; "class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="'.$tareas->nombre.'">
                         </div>
                         <div style="color: white; "class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="'.$tareas->descripcion.'">
                        </div>
                         <div style="color: white; "class="mb-3">
                            <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" value="'.$tareas->fechaInicio.'" >
                        </div>
                        <div style="color: white; "class="mb-3">
                            <label for="fechaEntrega" class="form-label">Fecha de Entrega</label>
                            <input type="date" class="form-control" id="fechaEntrega" name="fechaEntrega" value="'.$tareas->fechaEntrega.'">
                        </div>
                        <div style="color: white;" class="mb-3">
                            <label for="idProyecto" class="form-label">Id Proyecto</label>
                            <input type="number" class="form-control" id="idProyecto" name="idProyecto"  value="'.$tareas->idProyecto.'" >
                        </div>';
                foreach ($sql2 as $tarea){
                        echo '<div style="color: white;" class="mb-3">
                            <label for="idUsuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="idUsuario" name="idUsuario"  required value="'.$tarea->idUsuario.'" >
                        </div>'
                        ;  
                }
            }
            ?>
            
            <div style="color: white; margin-top: 10px; display: flex; justify-content: space-between;" class="row">
                <div class="col-4">
                    <?php 
                        if($_SESSION['cargo'] == 1) {
                            ?>
                            <button type="button" class="btn btn-outline-dark text-white" onclick="location.href='../tablas/tablaTareas.php'">Atras</button>
                            <?php
                        } else if($_SESSION['cargo'] == 2) {
                            ?><button type="button" class="btn btn-outline-dark text-white" onclick="location.href='../tablas/tablaTareasProyectos.php'">Atras</button>
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