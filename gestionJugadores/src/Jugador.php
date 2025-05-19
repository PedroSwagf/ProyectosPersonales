<?php
namespace App;

require_once "Conexion.php";

class Jugador {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConexion(); 
    }

    public function obtenerJugadores() {
        $sql = "SELECT * FROM `jugadores`";
        return $this->conexion->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }    

    public function insertarJugador($nombre, $apellidos, $posicion, $dorsal, $codigo_barras, $ruta_imagen) {
        $sql = "INSERT INTO jugadores (nombre, apellidos, posicion, dorsal, codigo_barras, ruta_imagen)
                VALUES (:nombre, :apellidos, :posicion, :dorsal, :codigo_barras, :ruta_imagen)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            ":nombre" => $nombre,
            ":apellidos" => $apellidos,
            ":posicion" => $posicion,
            ":dorsal" => $dorsal,
            ":codigo_barras" => $codigo_barras,
            ":ruta_imagen" => $ruta_imagen
        ]);
    }
    
    
    public function codigoBarrasExiste($codigo_barras) {
        $sql = "SELECT COUNT(*) FROM jugadores WHERE codigo_barras = :codigo_barras";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':codigo_barras' => $codigo_barras]);
        return $stmt->fetchColumn() > 0; 
    }

    public function dorsalExiste($dorsal) {
        $sql = "SELECT COUNT(*) AS total FROM jugadores WHERE dorsal = :dorsal";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':dorsal' => $dorsal]);
        return $stmt->fetchColumn() > 0;
    }
}