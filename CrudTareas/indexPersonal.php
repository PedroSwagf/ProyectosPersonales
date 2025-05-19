<?php
    session_start();

    //comprobamos que si no existe ninguna sesion nos redirija al index
    if (!isset($_SESSION['inicioSesion'])){
        header('Location: index.php');
    }


    //verificamos quien puede o no  acceder a esta pagina, en este caso restringimos el acceso al Coordinador. Ya que 
    //Administrador puede acceder a esta pagina para verificar que todo va bien en la pagina
    if ($_SESSION['cargo'] != 3){
        session_destroy();
        header('Location: index.php');
    }
    include('plantillas/encabezado.php');
    include('modelo/conexion.php');
    include('modelo/funciones.php');


    $nombreUsuario = $_SESSION['inicioSesion'];

    //comprobacion de la session del error de verificar el usuario
    if (isset($_SESSION['error_message'])) {
        ?>
        <div class="alert alert-danger" style="text-align: center "> <?php echo $_SESSION['error_message'] ?> </div>
        <?php
        unset($_SESSION['error_message']); // Clear the session variable
    }

    //mostramos el mensaje de bienvenida
    if(isset($_COOKIE['bienvenida_msg'])) {
        echo '<div class="alert alert-danger text-center" role="alert">' . $_COOKIE['bienvenida_msg'] . '</div>';
            setcookie('bienvenida_msg', '', time() - 60, '/');
    }
    
    $nombreUsuario = $_SESSION['inicioSesion'];


 //variable para la cantidad filas por la paginacion
    $productosPorPagina = 5;
    
   

    //comprobacion de la paginacion
    if (isset($_GET['pagina'])){
        $pagina = $_GET['pagina'];
    } else {
        $pagina =1;
        $_GET['pagina']=1;
    }
    
    $sql = "SELECT a.idTarea,a.nombre as nombre,
                   a.descripcion as descripcion,
                   a.fechaInicio as fechaInicio, 
                   a.fechaEntrega as fechaEntrega,
                   a.idProyecto as idProyecto,
                   b.idUsuario as idUsuario
     FROM tareas a ,usuariosTarea b WHERE a.idTarea = b.idTarea AND b.idUsuario = '".$_SESSION['inicioSesion']."'
     LIMIT " .(($pagina - 1)* $productosPorPagina).",".$productosPorPagina;
    
    $resultado=$conexion->query($sql);
    
    $sql= "SELECT count(*) as numero_l FROM tareas";
    
    $resulMaximo=$conexion->query($sql);
    
    $maximoElementos=$resulMaximo->fetch(PDO::FETCH_ASSOC)['numero_l'];

?>

 <!--tabla de las tareas-->
 <div class="container">
        <div class="row">
            <h1 style="color: white; "align="center">Lista de tus tareas</h1><hr>
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr class="table-dark text-center">
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Entrega</th>
                            <th>ID Proyecto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultado->rowCount() > 0){
                            while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)){
                                echo '<tr style="text-align:center">';
                                echo '<td class="table-danger center-table-danger">'.$fila['nombre'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['descripcion'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['fechaInicio'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['fechaEntrega'].'</td>';
                                echo '<td class="table-danger center-table-danger">'.$fila['idProyecto'].'</td>';
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
                                    <a class="page-link" href="indexPersonal.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous>
                                        <span aria-hidden="true">&laquo;</span>
                                    </a></li>';
                        } else {
                            echo '<li class="page-item disabled">
                            <a class="page-link" href="indexPersonal.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous><<
                                <span aria-hidden="true">&laquo;</span>
                            </a></li>';
                        }
                    } else {
                        echo '<li class="page-item disabled">
                            <a class="page-link" href="indexPersonal.php?pagina='. ($_GET['pagina'] - 1) .'" arial-label="Previous><<
                                <span aria-hidden="true">&laquo;</span>
                            </a></li>';
                    }
                      $cantidadPaginas=ceil($maximoElementos/5);
                      

                      for ($i=1; $i <=$cantidadPaginas; $i++){
                        if ($_GET['pagina'] == $i) {
                            
                            echo '<li class="page-item disabled"><a class="page-link" href="indexPersonal.php?pagina='.$i.'">'.$i.'</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="indexPersonal.php?pagina='.$i.'">'.$i.'</a></li>';;
                        }
                        
                      }

                        if (isset($_GET['pagina'])){
                        if ((($_GET['pagina']) * $productosPorPagina) < $maximoElementos) {
                            echo '<li class="page-item">
                                    <a class="page-link" href="indexPersonal.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span> 
                                    </a></li>';
                        } else {
                            echo '<li class="page-item disabled">
                            <a class="page-link" href="indexPersonal.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span> 
                            </a></li>';
                        } 
                        echo '</ul>';
                        echo '</nav>';
                        } else {
                            echo '<li class="page-item">
                                    <a class="page-link" href="indexPersonal.php?pagina='. ($_GET['pagina'] + 1) .'" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span> 
                                    </a></li>';
                        }
                    
                    ?>


              


<?php
    //print_r ($_SESSION);
    include('plantillas/pie.php');
    $conexion=null;
?>