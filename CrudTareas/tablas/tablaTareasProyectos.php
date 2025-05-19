<?php
    session_start();
    //hacemos la comprobacion del cargo para restringir el acceso a la pagina, en este caso restrinjimos el acceso al personal
if ($_SESSION['cargo'] == 3){
    session_destroy();
    header('Location: ../index.php');
}
    include('../plantillas/encabezadoTablas.php');
    include('../modelo/conexion.php');
    include('../modelo/funciones.php');

    //mostramos el mensaje de usuario existe en la tarea
    if(isset($_COOKIE['usuarioExiste_msg'])) {
        echo '<div class="alert alert-danger text-center" role="alert">' . $_COOKIE['usuarioExiste_msg'] . '</div>';
            setcookie('usuarioExiste_msg', '', time() - 60, '/');
    }

    //mostramos el mensaje de usuario registrado en la tarea
    if(isset($_COOKIE['usuarioRegistrado_msg'])) {
        echo '<div class="alert alert-danger text-center" role="alert">' . $_COOKIE['usuarioRegistrado_msg'] . '</div>';
            setcookie('usuarioRegistrado_msg', '', time() - 60, '/');
    }

    //mostramos el mensaje de usuario eliminado en la tarea
    if(isset($_COOKIE['usuarioEliminado_msg'])) {
        echo '<div class="alert alert-danger text-center" role="alert">' . $_COOKIE['usuarioEliminado_msg'] . '</div>';
            setcookie('usuarioEliminado_msg', '', time() - 60, '/');
    }
    
    //comprobamos errores
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if(!isset($_POST['codigo'])){
        header('Location: ../indexCoordinador.php');       
    } else {
        $codigo = $_POST['codigo'];
    }

    //comprobacion de la session del error de verificar el usuario
    if (isset($_SESSION['error_message'])) {
        ?>
        <div class="alert alert-danger" style="text-align: center "> <?php echo $_SESSION['error_message'] ?> </div>
        <?php
        unset($_SESSION['error_message']); // Clear the session variable
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
    
    $sql1 = "SELECT a.idTarea, a.nombre as nombre,
                    a.descripcion as descripcion,
                    a.fechaInicio as fechaInicio, 
                    a.fechaEntrega as fechaEntrega,
                    a.idProyecto as idProyecto,
                    b.idUsuario as idUsuario
                            FROM tareas a
            INNER JOIN usuariosTarea b ON a.idTarea = b.idTarea
            WHERE a.idProyecto = '$codigo'
            LIMIT " .(($pagina - 1)* $productosPorPagina).",".$productosPorPagina;

    $resultado = $conexion->query($sql1);
    
    // Consulta SQL para obtener el número total de productos
    $sql= "SELECT count(*) as numero_l FROM tareas";
    
    $resulMaximo=$conexion->query($sql);
    
    $maximoElementos=$resulMaximo->fetch(PDO::FETCH_ASSOC)['numero_l'];

    
?>

 <!--tabla de las tareas-->
 <div class="container">
    <div class="row">
        <div class="col-12">
            <h1 style="color: white;" align="center">Lista de tareas</h1><hr>
            <table class="table">
                <thead>
                    <tr class="table-dark text-center">
                        <th>ID Tarea</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Entrega</th>
                        <th>ID Proyecto</th>
                        <th>ID Usuario</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- recorro con un bucle para pintar los datos en la tabla-->
                    <?php
                        if ($resultado->rowCount() > 0){
                            while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)){
                                echo '<tr style="text-align:center">';
                                echo '<td class="table-danger center-table-danger">'.$fila['idTarea'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['nombre'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['descripcion'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['fechaInicio'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['fechaEntrega'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['idProyecto'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['idUsuario'].'</td>';
                                echo '<td class="table-danger">';
                                echo '<form action="../detalles/detallesTareaCo.php" method="POST">';
                                echo '<input type="hidden" name="idTarea" id="codigo" value="'.$fila['idTarea'].'"/>';
                                echo '<button type="submit" class="btn btn-dark btn-sm text-light">Editar</button>';
                                echo '</form>';
                                echo '<form action="../eliminar/eliminarTareaCo.php" method="POST">';
                                echo '<input type="hidden" name="idTarea" id="codigo" value="'.$fila['idTarea'].'"/>';
                                echo '<button type="submit" class="btn btn-danger btn-sm text-light" style="margin-top: 10px;">Borrar</button>';
                                echo '</form>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div> 
                <?php
                //aqui empezamos el codigo de la paginacion

                echo '<nav aria-label="Page navigation example">';
                echo '<ul class="pagination" style="justify-content: center;">';
                //si la pagina es mayor que 1   
                if (isset($_GET['pagina'])){
                        if ($_GET['pagina'] > 1) {
                            echo '<li class="page-item">
                                    <a class="page-link" href="tablaTareasProyectos.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous>
                                        <span aria-hidden="true">&laquo;</span>
                                    </a></li>';
                        } else {
                            echo '<li class="page-item disabled">
                            <a class="page-link" href="tablaTareasProyectos.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous><<
                                <span aria-hidden="true">&laquo;</span>
                            </a></li>';
                        }
                    } else {
                        echo '<li class="page-item disabled">
                            <a class="page-link" href="tablaTareasProyectos.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous><<
                                <span aria-hidden="true">&laquo;</span>
                            </a></li>';
                    }
                      $cantidadPaginas=ceil($maximoElementos/5);
                      

                      for ($i=1; $i <=$cantidadPaginas; $i++){
                        if ($_GET['pagina'] == $i) {
                            
                            echo '<li class="page-item disabled"><a class="page-link" href="tablaTareasProyectos.php?pagina='.$i.'">'.$i.'</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="tablaTareasProyectos.php?pagina='.$i.'">'.$i.'</a></li>';;
                        }
                        
                      }

                        if (isset($_GET['pagina'])){
                        if ((($_GET['pagina']) * $productosPorPagina) < $maximoElementos) {
                            echo '<li class="page-item">
                                    <a class="page-link" href="tablaTareasProyectos.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span> 
                                    </a></li>';
                        } else {
                            echo '<li class="page-item disabled">
                            <a class="page-link" href="tablaTareasProyectos.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span> 
                            </a></li>';
                        } 
                        echo '</ul>';
                        echo '</nav>';
                        } else {
                            echo '<li class="page-item">
                                    <a class="page-link" href="tablaTareasProyectos.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span> 
                                    </a></li>';
                        }
                    
                    ?>
    <!-- aqui empieza el boton de nueva tarea con un modal-->
    <div class="row">
                <div class="col-6">
                    <!-- Boton de modal  tareas-->
                    <p style="color: white;">Nueva Tarea</p>
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#TareasModal">+</button>
                    <!-- Modal tareas -->
                    <div class="modal fade" id="TareasModal" tabindex="-1" aria-labelledby="TareasModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-dark text-white">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="TareasModal">Añadir nuevas tareas:</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                        <form action="..\registrar\registrarTareaCoor.php" method="POST">
                                        <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre Tarea</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la tarea" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripcion</label>
                                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Describe la Tarea" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                                        <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fechaEntrega" class="form-label">Fecha Entrega</label>
                                        <input type="date" class="form-control" id="fechaEntrega" name="fechaEntrega" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="idProyecto" class="form-label">id Proyecto</label>
                                        <input type="text" class="form-control" id="idProyecto" name="idProyecto" value="<?php echo $codigo?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombreUsuario" class="form-label">id Usuario</label>
                                        <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
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
                    <?php
                        //aqui vamos a obtener los datos de las tablas para despues poner en la opciones del dropdown

                        // Consulta para obtener las tareas
                            $sqlTareas = "SELECT DISTINCT idTarea, nombre FROM tareas";
                            $resultadoTareas = $conexion->query($sqlTareas);

                            
                            // Consulta para obtener los usuarios asociados a tareas
                            $sqlUsuariosTareas = "SELECT * FROM usuarios WHERE idCargo = 3";

                            $resultadoUsuariosTareas = $conexion->query($sqlUsuariosTareas);

                    ?>
            <!-- aqui empieza el boton de Agregar usuarios a tarea con un modal-->
            <div class="col-6">
                <p style="color: white;">Agregar usuarios a Tareas</p>
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#TareasProyectos">+</button>
                <!-- Modal para agregar usuarios a tareas -->
                <div class="modal fade" id="TareasProyectos" tabindex="-1" aria-labelledby="TareasProyectosLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header">
                                <h5 class="modal-title" id="TareasProyectosLabel">Agregar usuarios a Tareas</h5>
                            </div>
                            <div class="modal-body">
                                <form action="..\registrar\registrarUsuariosTarea.php" method="POST">
                                    <div class="row">
                                        <div class="col">
                                            <div class="dropdown">
                                                <select class="form-select" name="idTarea" aria-label="select de las tareas"  style="background-color: #212529; color: #fff;">
                                                    <option selected>Tareas:</option>
                                                        <?php while ($tarea = $resultadoTareas->fetch(PDO::FETCH_ASSOC)): ?>
                                                    <option value="<?php echo $tarea['idTarea']; ?>" style="background-color: #212529; color: #fff;"><?php echo $tarea['nombre'];?></option>
                                                        <?php endwhile; ?>
                                                </select>           
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="dropdown">
                                                <select class="form-select" name="nombreUsuario" aria-label="select de los usuarios" style="background-color: #212529; color: #fff;">
                                                    <option selected>Usuarios:</option>
                                                        <?php while ($usuarioTarea = $resultadoUsuariosTareas->fetch(PDO::FETCH_ASSOC)): ?>
                                                    <option value="<?php echo $usuarioTarea['nombreUsuario']; ?>" style="background-color: #212529; color: #fff;"><?php echo $usuarioTarea['nombreUsuario'];?></option>
                                                        <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="display: flex; justify-content: space-between;">
                                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" action="Eliminar" id="Eliminar" name="accion" value="Eliminar" class="btn btn-outline-danger">Eliminar</button>
                                            <button type="submit" action="agregar" id="Agregar" name="accion" value="Guardar" class="btn btn-outline-success">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br> <br> <br>
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
                }
            ?>
        </div>
    </div>
</div>

<?php
    include('../plantillas/pie.php');
    $conexion=null;
?>