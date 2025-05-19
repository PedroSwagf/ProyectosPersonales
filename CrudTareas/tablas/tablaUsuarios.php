<?php
    session_start();

    //hacemos la comprobacion del cargo para restringir el acceso a la pagina, solo puede acceder el administrador
    if ($_SESSION['cargo'] != 1){
        session_destroy();
        header('Location: ../index.php');
    }

    include('../plantillas/encabezadoTablas.php');
    include('../modelo/conexion.php');
    include('../modelo/funciones.php');

    //hacemos la comprobacion del cargo para restringir el acceso a las paginas
    if ($_SESSION['cargo'] == 2 || $_SESSION['cargo'] == 3){
        header('Location: index.php');
    }

    //mostramos el mensaje de usuario registrado
    if(isset($_COOKIE['userRegistrado_msg'])) {
        echo '<div class="alert alert-danger text-center" role="alert">' . $_COOKIE['userRegistrado_msg'] . '</div>';
        setcookie('userRegistrado_msg', '', time() - 60, '/');
    }

    //mostramos el mensaje de usuario eliminado
    if(isset($_COOKIE['userEliminado_msg'])) {
        echo '<div class="alert alert-danger text-center" role="alert">' . $_COOKIE['userEliminado_msg'] . '</div>';
        setcookie('userEliminado_msg', '', time() - 60, '/');
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
    
    $sql = "SELECT * FROM usuarios ORDER BY idCargo LIMIT " .(($pagina - 1)* $productosPorPagina).",".$productosPorPagina;
    
    //llamo a la consulta de la tabla
    $resultado=$conexion->query($sql);

    //cuento la cantidad de filas para la paginacion
    $sql= "SELECT count(*) as numero_l FROM usuarios ";
    
    $resulMaximo=$conexion->query($sql);
    
    $maximoElementos=$resulMaximo->fetch(PDO::FETCH_ASSOC)['numero_l'];

    

?>
 <!--tabla de las usuarios-->
 <div class="container">
        <div class="row">
            <h1 style="color: white; "align="center">Lista de usuarios</h1><hr>
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr class="table-dark" style="text-align:center">
                            <th>Login Ususario</th>
                            <th>Contraseña</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>ID Cargo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultado->rowCount() > 0){
                            while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)){
                                echo '<tr style="text-align:center">';
                                echo '<td class="table-danger center-table-danger">'.$fila['nombreUsuario'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['contraseña'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['nombre'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['apellidos'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['idCargo'].'</td>';
                                echo '<td class="table-danger">';
                                echo '<form action="../detalles/detallesUsuarios.php" method="POST">';
                                echo '<input type="hidden" name="codigo" id="codigo" value="'.$fila['nombreUsuario'].'"/>';
                                echo '<button type="submit" class="btn btn-dark btn-sm text-light">Editar</button>';
                                echo '</form>';
                                echo '<form action="../eliminar/eliminarUsuarios.php" method="POST">';
                                echo '<input type="hidden" name="nombreUsuario" id="codigo" value="'.$fila['nombreUsuario'].'"/>';
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
                                    <a class="page-link" href="tablaUsuarios.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous>
                                        <span aria-hidden="true">&laquo;</span>
                                    </a></li>';
                        } else {
                            echo '<li class="page-item disabled">
                            <a class="page-link" href="tablaUsuarios.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous><<
                                <span aria-hidden="true">&laquo;</span>
                            </a></li>';
                        }
                    } else {
                        echo '<li class="page-item disabled">
                            <a class="page-link" href="tablaUsuarios.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous><<
                                <span aria-hidden="true">&laquo;</span>
                            </a></li>';
                    }
                      $cantidadPaginas=ceil($maximoElementos/5);
                      

                      for ($i=1; $i <=$cantidadPaginas; $i++){
                        if ($_GET['pagina'] == $i) {
                            
                            echo '<li class="page-item disabled"><a class="page-link" href="tablaUsuarios.php?pagina='.$i.'">'.$i.'</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="tablaUsuarios.php?pagina='.$i.'">'.$i.'</a></li>';;
                        }
                        
                      }

                        if (isset($_GET['pagina'])){
                        if ((($_GET['pagina']) * $productosPorPagina) < $maximoElementos) {
                            echo '<li class="page-item">
                                    <a class="page-link" href="tablaUsuarios.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span> 
                                    </a></li>';
                        } else {
                            echo '<li class="page-item disabled">
                            <a class="page-link" href="tablaUsuarios.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span> 
                            </a></li>';
                        } 
                        echo '</ul>';
                        echo '</nav>';
                        } else {
                            echo '<li class="page-item">
                                    <a class="page-link" href="tablaUsuarios.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span> 
                                    </a></li>';
                        }
                    
                    ?>

                <div class="col-4">
                        <!-- Boton de modal  Usuarios-->
                        <p style="color: white;">Nuevo Usuario</p>
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#UsuariosModal">+</button>
                        
                        <!-- Modal usuarios -->
                        <div class="modal fade" id="UsuariosModal" tabindex="-1" aria-labelledby="UsuariosModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="UsuariosModal">Añadir nuevas usuarios:</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="../registrar/registroUser.php" method="POST">
                                            <div class="mb-3">
                                                <label for="nombreUsuario" class="form-label">Login usuario</label>
                                                <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" require>
                                            </div>                                        
                                            <div class="mb-3">
                                                <label for="contraseña" class="form-label">Contraseña</label>
                                                <input type="password" class="form-control" id="contraseña" name="contraseña"require>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre"  require>
                                            </div>
                                            <div class="mb-3">
                                                <label for="apellidos" class="form-label">Apellidos</label>
                                                <input type="text" class="form-control" id="apellidos" name="apellidos" require>
                                            </div>
                                            <div class="mb-3">
                                                <label for="idCargo" class="form-label">id del Cargo</label>
                                                <input type="number" class="form-control" id="idCargo" name="idCargo" require>
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
                <button type="button" class="btn btn-dark" onclick="location.href='../indexAdministrador.php'">Atras</button>     
            </div>
        </div>
</div>


<?php
    //print_r ($_SESSION);
    include('../plantillas/pie.php');
    $conexion=null;
?>