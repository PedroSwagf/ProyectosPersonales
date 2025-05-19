<?php
    session_start();
     //hacemos la comprobacion del cargo para restringir el acceso a la pagina, en este caso restrinjimos el acceso al personal
    if ($_SESSION['cargo'] != 1){
        session_destroy();
        header('Location: ../index.php');
    }
    
    include('../plantillas/encabezadoTablas.php');
    include('../modelo/conexion.php');
    include('../modelo/funciones.php');
        
    //comprobacion de la session del error de verificar el usuario
    if (isset($_SESSION['error_message'])) {
        ?>
        <div class="alert alert-danger" style="text-align: center "> <?php echo $_SESSION['error_message'] ?> </div>
        <?php
        unset($_SESSION['error_message']); // Clear the session variable
    }

    //mostramos el mensaje de proyecto añadido
    if(isset($_COOKIE['proyecto_msg'])) {
        echo '<div class="alert alert-danger text-center" role="alert">' . $_COOKIE['proyecto_msg'] . '</div>';
            setcookie('proyecto_msg', '', time() - 60, '/');
    }

    //mostramos el mensaje de proyecto elimando
    if(isset($_COOKIE['proyectoEliminado_msg'])) {
        echo '<div class="alert alert-danger text-center" role="alert">' . $_COOKIE['proyectoEliminado_msg'] . '</div>';
            setcookie('proyectoEliminado_msg', '', time() - 60, '/');
    }

 //variable para la cantidad filas por la paginacion
    $productosPorPagina = 5;
    

    //comprobacion de la paginacion

    if (isset($_GET['pagina'])){
        $pagina = $_GET['pagina'];
    } else {
        $pagina =1;
        $_GET['pagina']=1;
    }
    
    $sql = "SELECT * FROM proyectos LIMIT " .(($pagina - 1)* $productosPorPagina).",".$productosPorPagina;
    
    $resultado=$conexion->query($sql);
    
    $sql= "SELECT count(*) as numero_l FROM proyectos";
    
    $resulMaximo=$conexion->query($sql);
    
    $maximoElementos=$resulMaximo->fetch(PDO::FETCH_ASSOC)['numero_l'];

?>

 <!--tabla de las proyectos-->
 <div class="container">
        <div class="row">
            <h1 style="color: white; "align="center">Lista de proyectos</h1><hr>
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr class="table-dark text-center">
                            <th>Nombre Proyecto</th>
                            <th>Descripción</th>
                            <th>ID Proyecto</th>
                            <th>ID Coordinador</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultado->rowCount() > 0){
                            while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)){
                                echo '<tr style="text-align:center">';
                                echo '<td class="table-danger center-table-danger">'.$fila['nombreProyecto'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['descripcion'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['idProyecto'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['idCoord'].'</td>';
                                echo '<td class="table-danger">';
                                echo '<form action="../detalles/detallesProyecto.php" method="POST">';
                                echo '<input type="hidden" name="codigo" id="codigo" value="'.$fila['idProyecto'].'"/>';
                                echo '<button type="submit" class="btn btn-dark btn-sm text-light">Editar</button>';
                                echo '</form>';
                                echo '<form action="../eliminar/eliminarProyectos.php" method="POST">';
                                echo '<input type="hidden" name="idProyecto" id="codigo" value="'.$fila['idProyecto'].'"/>';
                                echo '<button type="submit" class="btn btn-danger btn-sm text-light" style="margin-top: 10px;">Borrar</button>';
                                echo '</form>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                //aqui empezamos el codigo de la paginacion

                echo '<nav aria-label="Page navigation example">';
                echo '<ul class="pagination" style="justify-content: center;">';
                //si la pagina es mayor que 1   
                if (isset($_GET['pagina'])){
                        if ($_GET['pagina'] > 1) {
                            echo '<li class="page-item">
                                    <a class="page-link" href="tablaProyectos.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous>
                                        <span aria-hidden="true">&laquo;</span>
                                    </a></li>';
                        } else {
                            echo '<li class="page-item disabled">
                            <a class="page-link" href="tablaProyectos.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous><<
                                <span aria-hidden="true">&laquo;</span>
                            </a></li>';
                        }
                    } else {
                        echo '<li class="page-item disabled">
                            <a class="page-link" href="tablaProyectos.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous><<
                                <span aria-hidden="true">&laquo;</span>
                            </a></li>';
                    }
                      $cantidadPaginas=ceil($maximoElementos/5);
                      

                      for ($i=1; $i <=$cantidadPaginas; $i++){
                        if ($_GET['pagina'] == $i) {
                            
                            echo '<li class="page-item disabled"><a class="page-link" href="tablaProyectos.php?pagina='.$i.'">'.$i.'</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="tablaProyectos.php?pagina='.$i.'">'.$i.'</a></li>';;
                        }
                        
                      }

                        if (isset($_GET['pagina'])){
                        if ((($_GET['pagina']) * $productosPorPagina) < $maximoElementos) {
                            echo '<li class="page-item">
                                    <a class="page-link" href="tablaProyectos.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span> 
                                    </a></li>';
                        } else {
                            echo '<li class="page-item disabled">
                            <a class="page-link" href="tablaProyectos.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span> 
                            </a></li>';
                        } 
                        echo '</ul>';
                        echo '</nav>';
                        } else {
                            echo '<li class="page-item">
                                    <a class="page-link" href="tablaProyectos.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span> 
                                    </a></li>';
                        }
                    
                    ?>


                <div class="col-4">
                        <!-- Boton de modal  proyectos-->
                        <p style="color: white;">Nuevo Proyecto</p>
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#proyectoModal">+</button>
                        
                        <!-- Modal proyectos -->
                        <div class="modal fade" id="proyectoModal" tabindex="-1" aria-labelledby="proyectoModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="proyectoModal">Añadir nuevos Proyectos:</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="../registrar/registrarProyecto.php" method="POST">
                                            <div class="mb-3">
                                                <label for="nombreProyecto" class="form-label">Nombre Proyecto</label>
                                                <input type="text" class="form-control" id="nombreProyecto" name="nombreProyecto" placeholder="Nombre del Proyecto" require>
                                            </div>
                                            <div class="mb-3">
                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">Descripcion</label>
                                                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Describe la Tarea" require>
                                            </div>
                                            <div class="mb-3">
                                                <label for="idCoord" class="form-label">Coordinador</label>
                                                <input type="text" class="form-control" id="idCoord" name="idCoord" placeholder="Id del coordinador" require>
                                            </div>
                                            
                                            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" action="agregar" id="Agregar" name="accion" value="Guardar" class="btn btn-outline-success">Guardar</button>
                                            </div>
                                        </form>
                                    </div>                                                                  
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center"> 
                <?php 
                    if($_SESSION['cargo'] == 1) {
                        ?>
                        <button type="button" class="btn btn-dark" onclick="location.href='../indexAdministrador.php'">Atras</button>
                        <?php
                    } else if($_SESSION['cargo'] == 2) {
                        ?><button type="button" class="btn btn-dark" onclick="location.href='../indexCoordinador.php'">Atras</button>
                        <?php
                    }?>
            </div>
        </div>
</div>


<?php
    //print_r ($_SESSION);
    include('../plantillas/pie.php');
    $conexion=null;
?>