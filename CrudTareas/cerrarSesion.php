<?php
//a esta pagina no se puede acceder directamente 
session_start();
session_destroy();	// eliminamos la sesion
header("Location: login.php");
?>