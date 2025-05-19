<?php

try {
    
    /** aqui pondremos los datos para conectar con la base de datos */
    $dns = 'mysql:host=localhost;
                  dbname=proyecto;
                  charset=utf8';
    $user = 'root';
    $contraseña = '';
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO($dns,$user,$contraseña,$options);
} catch (PDOException $e) {
    die('Error al conectar a la DB' . $e->getMessage());
}
?>