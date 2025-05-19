<!DOCTYPE html>
<html>
    <head>
        <title>Encabezado</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link href="./index.css"/>
        <style>
            .list-group-item {
                display: flex;
                justify-content: space-between;
                align-items: left;
            }
           
            .list-group-item {
                margin-left: 100px; /* ajustamos la separacion de los valore dentro de la lista */
            }
            body {
                /*background-color: rgb(59, 178, 147 ); /* Cambiamos al color que queremos el fonde de la pagina */
                /*este siguiente codigo es para poner la imagen de fondo*/
                background-image: url('imagenes/fondo.jpg');
                background-size: cover;
                background-attachment: fixed;             
            }

            /* Estilos para el footer */
            footer {
                background-color: #343a40; /* Color de fondo oscuro */
                color: #fff; /* Color del texto blanco */
                position: fixed;
                bottom: 0;
                width: 100%;
            }

            /* Estilos para el contenido dentro del footer */
            .footer-content {
                padding: 1px; /* Espaciado interno */
            }

            /* Estilos para el nombre */
            .name {
                text-align: center; /* Alineación del texto al centro */
                width: 100%;
            }

            /* Estilos para el botón de Cerrar Sesión */
            .logout-button {
                text-align: right; /* Alineación del botón a la derecha */
            }

            .logout-button a {
                color: #fff; /* Color del texto blanco */
                background-color: #dc3545; /* Color de fondo rojo */
                padding: 5px 10px; /* Espaciado interno del botón */
                border-radius: 5px; /* Bordes redondeados */
            }
            
            .center-table-danger {
                text-align: center;
                vertical-align: middle;
            }
            
            .container-fluid.bg-dark.fixed-bottom {
                height: 35px; 
                display: flex;
                align-items: center; 
                justify-content: center; 
            }

        </style>
  
    </head> 
    <body>
    <header>
        <nav class="navbar navbar-dark bg-dark d-flex justify-content-between align-items:center">
            
            <div class="container-fluid">
            <img src="imagenes/logotipo.jpg" alt="" width="70" height="70" >
            <a class="navbar-brand" >Fernandez Service S.A</a>
                <div>
                <?php
                    // Verificar si la sesión está iniciada para mostrar el botón de Cerrar Sesión

                    if (isset($_SESSION['inicioSesion'])) {
                        echo '<a href="cerrarSesion.php" class="btn btn-dark text-danger text-end">Cerrar Sesión</a>';

                        //comprobamos errores
                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1);
                        error_reporting(E_ALL);
                    }
                    ?>
                </div>
            </div>
        </nav>
</header>


