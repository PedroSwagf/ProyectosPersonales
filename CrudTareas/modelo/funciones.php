<?php

include('conexion.php');

//verificar idcargo
// Inicio de la función verificarCargo que toma dos parámetros: $conexion y $nombreUsuario
function verificarCargo($conexion, $nombreUsuario) {
    try {
        // Preparar la consulta SQL para seleccionar el idCargo del usuario basado en su nombreUsuario
        $sql = "SELECT idCargo FROM usuarios WHERE nombreUsuario = :nombre";
        // Preparar la declaración SQL utilizando la conexión proporcionada
        $statement = $conexion->prepare($sql);
        // Vincular el parámetro :nombre con el valor de $nombreUsuario para evitar inyecciones SQL
        $statement->bindParam(':nombre', $nombreUsuario);
        // Ejecutar la consulta preparada
        $statement->execute();
        // Obtener el primer valor de la columna idCargo de la fila resultante
        $resultado = $statement->fetchColumn();

        // Devolver el resultado obtenido, que es el idCargo del usuario
        return $resultado;
    } catch (PDOException $e) {
        // Capturar y manejar cualquier excepción de PDO que pueda ocurrir durante la ejecución de la consulta
        echo "Error: " . $e->getMessage();
    }
}

//verificar login
function verificarlogin($conexion, $nombre, $contraseña){
    try{// Preparar la consulta SQL
        $sql = "SELECT count(*) as total FROM usuarios WHERE nombreUsuario = :nombre AND contraseña = :contrasena";
        // Preparar la declaración SQL
        $statement = $conexion->prepare($sql);
         // Vincular los parámetros a la declaración SQL
        $statement->bindParam(':nombre', $nombre);
        $statement->bindParam(':contrasena', $contraseña);
        // Ejecutar la consulta preparada
        $statement->execute();

        $resultado = $statement->fetchColumn(); // Recupera el resultado de la consulta

        return $resultado; // Devuelve el resultado para su posterior procesamiento

    }catch(PDOException $e){
        //manejamos la excepcion y mostramos el mensaje de error
        echo "Error: " . $e->getMessage();
        return null; // Devolver null en caso de error para indicar que no se pudo verificar el inicio de sesión
    }
}

//verificar si el usuario existe para inserta la tarea
function verificarUsuarioExistente($conexion, $usuario) {
    try{// Preparar la consulta SQL
        $sql = "SELECT COUNT(*) AS TotalUsuarios FROM usuarios WHERE idUsuario = :usuario";
        // Preparar la declaración SQL
        $statement = $conexion->prepare($sql);
        // Vincular el parámetro a la declaración SQL
        $statement->bindParam(':usuario', $usuario);
        // Ejecutar la declaración SQL
        $statement->execute();
        //recuperamos el resultado.
        $resultado = $statement->fetchColumn();
        // Devolver el resultado
        return $resultado;

      
    } catch (PDOException $e) {
        // Manejar la excepción y mostrar el mensaje de error
        echo "Error: " . $e->getMessage();
        return null; // Devolver null en caso de error para indicar que no se pudo verificar la existencia del usuario
    }
}



//obtener contraseña cifrada de un usuario en la base de datos.
function contraseñaCifrada($conexion,$nombreUsuario){
    try{ // Preparar la consulta SQL
        $sql = "SELECT contraseña FROM usuarios WHERE nombreUsuario = :nombreUsuario";
        // Preparar la declaración SQL
        $statement = $conexion->prepare($sql);
        // Vincular el parámetro a la declaración SQL
        $statement->bindParam(':nombreUsuario',$nombreUsuario);
        // Ejecutar la declaración SQL
        $statement->execute();
        // Recuperar el resultado de la consulta como un array asociativo
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        // Extraer la contraseña cifrada del resultado
        $contraseñaCifrada = $result['contraseña'];
        // Devolver la contraseña cifrada
        return $contraseñaCifrada;
        
    } catch (PDOException $e) {
        // Manejar la excepción y mostrar el mensaje de error
        echo "Error: " . $e->getMessage();
        return null; // Devolver null en caso de error para indicar que no se pudo obtener la contraseña cifrada
    }
}

//obtener si el usuario esta ya asociado a esa tarea
function usuarioAsociadoTarea($conexion, $idTarea, $nombreUsuario) {
    try {
        // Preparar la consulta SQL
        $sql = "SELECT * FROM usuariosTarea WHERE idTarea = :idTarea AND idUsuario = :nombreUsuario";
        // Preparar la sentencia SQL
        $statement = $conexion->prepare($sql);
        // Vincular parámetros a la sentencia SQL
        $statement->bindParam(':idTarea', $idTarea, PDO::PARAM_INT); // Asumiendo que idTarea es un entero
        $statement->bindParam(':nombreUsuario', $nombreUsuario, PDO::PARAM_STR); // Asumiendo que nombreUsuario es una cadena
        // Ejecutar la sentencia SQL
        $statement->execute();
        // Devolver true si el usuario está asociado con la tarea, false en caso contrario
        return $statement->rowCount() > 0;
    } catch (PDOException $e) {
        // Registrar el error para fines de depuración
        error_log("Error al verificar el usuario a la tarea: " . $e->getMessage());
        return false;
    }
}


?>