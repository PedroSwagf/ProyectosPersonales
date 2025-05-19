<?php
namespace App;

use PDO;
use PDOException; 

class Conexion {
    private $host = "localhost";
    private $db = "practicaUnidad5";
    private $user = "gestor";
    private $pass = "abc123.";
    private $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // Método 
    public function getConexion() {
        return $this->conexion;
    }
}