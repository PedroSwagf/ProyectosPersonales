<?php 

$host = 'localhost';
$dbname = 'pedroDB';
$user = 'root';
$password = '';




// $sql="Select * from tareas";
// $resultado= $conexion->query($sql);

try{
    $conexion = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo "Error: Error al conectar la BD: ".$e->getMessage();
    file_put_contents("PDOErrors.txt", "\r\n".date('j F, Y, g:i a').$e->getMessage(), FILE_APPEND);
    exit;
}

?>


