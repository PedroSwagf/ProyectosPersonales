<?php

/**
 * primero empezaremos creando una clase que usaremos en comun para todos los usuarios
 * ya que estos atributos son comunes en todos
 * utilizamos un metodo abstracto ya que tenemos facil polimorfimo y esta nos actua como una
 * plantilla que nos permite obligar a las clases hijas a implemntar cierto metodos.
 */

 abstract class Persona {

    /**
     * @var int numero de objetos crados de la clase
     */

     protected static $contadorPersonas = 0;

     /** declaramos los atributos comunes */

     protected $nombre;
     protected $apellido1;
     protected $apellido2;
     protected $dni;
     protected $telefono;
     protected $direccion;
     protected $sexo;

     /**
     * Constructor de la clase Persona.
     *
     * @param string $nombre Nombre de la persona.
     * @param string $apellido1 Primer apellido.
     * @param string $apellido2 Segundo apellido.
     * @param string $dni Documento de identificación.
     * @param string $telefono Numero de telefono.
     * @param string $direccion Direccion.
     * @param string $sexo Genero de la persona.
     */

     public function __construct($nombre,$apellido1,$apellido2,$dni,$telefono,$direccion,$sexo) {
        $this -> nombre = $nombre;
        $this -> apellido1 = $apellido1;
        $this -> apellido2 = $apellido2;
        $this -> dni = $dni;
        $this -> direccion = $direccion;
        $this -> sexo = $sexo;
        self::$contadorPersonas++;
     }
     
     /** ahora devolvemos el numero total de personas creadas de la calse 
      * @return int numero de personas creadas
      */
     public static function numeroObejtosCreado() {
        return self::$contadorPersonas;
     }

     /** generamos un objeto de la clase de manera aleatoria
      * @return static objeto generado aleatorio
      */
    public static function generarAlAzar() {
        /** Creamos unos arrays con los datos para usar luego */
        $nombres = ['Juan','Pedro','Alexis','Maria','Mercedes','Alejandra'];
        $apellidos = ['Fernandez','Chacon','Martinez','Iglesias'];
        $sexos = ['Masculino','Femenino','Bisexual', 'helicoptero apache de combate'];
        /** ahora usamos los datos de lo arrays para generar la persona ramdon */
        $nombre = $nombres[array_rand($nombres)];
        $apellido1 = $apellidos[array_rand($apellidos)];
        $apellido2 = $apellidos[array_rand($apellidos)];
        /**
         * para el dni vamos a usar funciones integradas ya en php como:
         * strtoupper ->transformamos la cadena en mayuscula
         * random_bytes(4) ->Genera 4 bytes de datos binarios aleatorios. Cada byte tiene 8 bits, por lo que produce un total de 32 bits de datos aleatorios.
         * cabe destacar que esta funcion es criptograficamente segura
         * bin2hex -> convierte los 4 bytes en codigo Hexadecimal
         */
        $numeroDNI = strtoupper(bin2hex(random_bytes(4)));
        $letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $letra = $letras[array_rand($letras)];
        $dni = $numerosDNI . $letra;
        $telefono = rand(600000000, 699999999);
        $direccion = 'Calle falso numero'. rand(1, 300);
        $sexo = $sexos[array_rand($sexos)];

        return new static (
            $nombre,
            $apellido1,
            $apellido2,
            $dni,
            $telefono,
            $direccion,
            $sexo
        );
    }

    /** ahora convertimos el objeto en una cadena legible
     * @return string obejto representado en forma de texto
     */
    public function _toString() {
        return "Nombre: $this->nombre
                        $this->apellido1
                        $this->apellido2,
                DNI: $this->dni, 
                Telefono: $this->telefono, 
                Direccion: $this->direccion, 
                Sexo: $this->sexo";
    }
    
    /** definimos el metodo que define los atributos especiales de trabajar
     * @return string mensaje que indica la activadad de cada persona
     */

     abstract public function trabajar();
 }

 //* definimos la clase administrativo */
 class Administrativo extends Persona {
    /**
     * @var int años de servicio.
     */
    private $tiempoServicio;

    public function __construct($nombre, $apellido1, $apellido2, $dni, $telefono, $direccion, $sexo, $tiempoServicio) {
        parent::__construct($nombre, $apellido1, $apellido2, $dni, $telefono, $direccion, $sexo);
        $this->tiempoServicio = $tiempoServicio; 
    }

    /** indicamos el trabajo que realiza
     * @return string
     */
    public function trabajar() {
        return "Soy un administrativo y realizo tareas de oficina.";
    }

    public function _toString() {
        return parent::_toString() . ", mis años de servicio son: $this->$tiempoServicio";
    }
 }

 class Conserjes extends Persona {
    private $tiempoServicio;

    public function __construct($nombre,$apellido1,$apellido2,$dni,$telefono,$sexo,$tiempoServicio) {
        parent::__construct($nombre, $apellido1, $apellido2, $dni, $telefono, $direccion, $sexo);
        $this->tiempoServicio = $tiempoServicio; 
    }

    public function trabajar() {
        return "Soy conserje y realizo tareas de mantenimiento.";
    }

    public function _toString() {
        return parent::_toString() . ", mis años de servicio son: $this->$tiempoServicio";
    }
 }
 /** ahora definimos la clase Plimpieza*/
 class Plimpieza extends Persona {
    private $tiempoServicio;

    public function __construct($nombre,$apellido1,$apellido2,$dni,$telefono,$sexo,$tiempoServicio) {
        parent::__construct($nombre, $apellido1, $apellido2, $dni, $telefono, $direccion, $sexo);
        $this->tiempoServicio = $tiempoServicio; 
    }

    public function trabajar() {
        return "Soy personal de limpieza y realizo tareas de limpieza.";
    }

    public function _toString() {
        return parent::_toString() . ", mis años de servicio son: $this->$tiempoServicio";
    }
 }

 class Profesorado extends Persona {
    private $tiempoServicio;
    private $materias;
    private $cargoProfesorado;

    public function __construct($nombre, $apellido1, $apellido2, $dni, $telefono, $direccion, $sexo, $tiempoServicio, $materias, $cargoProfesorado) {
        parent::__construct($nombre, $apellido1, $apellido2, $dni, $telefono, $direccion, $sexo);
        $this->tiempoServicio = $tiempoServicio;
        $this->materias = $materias;
        $this->cargoProfesorado = $cargoProfesorado;
    }

    public function trabajar() {
        return "Soy profesor/a con $this->tiempoServicio años de servicio, enseño las materias: " 
            . implode(", ", $this->materias) 
            . ", y mi cargo directivo es: $this->cargoProfesorado.";
    }

    public function __toString() {
        return parent::__toString() 
            . ", Años de servicio: $this->tiempoServicio, Materias: " 
            . implode(", ", $this->materias) 
            . ", Cargo directivo: $this->cargoProfesorado";
    }
 }

 /** ahora definimos la clase alumno */

 class Alumno extends Persona {
    protected $curso;
    protected $grupo;

    public function __construct($nombre, $apellido1, $apellido2, $dni, $telefono, $direccion, $sexo, $curso, $grupo) {
        parent::__construct($nombre, $apellido1, $apellido2, $dni, $telefono, $direccion, $sexo);
        $this->curso = $curso;
        $this->grupo = $grupo;
    }   
    public function trabajar() {
        return "Soy un estudiante de ESO y estoy estudiando.";
    }
    public function __toString() {
        return parent::__toString() . ", Curso: $this->curso, Grupo: $this->grupo";
    }
}



/** Clase AlumnoBachillerato */
class AlumnoBachillerato extends Alumno {
    public function trabajar() {
        return "Soy un estudiante de Bachillerato y estoy estudiando.";
    }
}

class AlumnoFP extends Alumno {
    private $cicloFormativo;

    public function __construct($nombre, $apellido1, $apellido2, $dni, $telefono, $direccion, $sexo, $curso, $grupo, $cicloFormativo) {
        parent::__construct($nombre, $apellido1, $apellido2, $dni, $telefono, $direccion, $sexo, $curso, $grupo);
        $this->cicloFormativo = $cicloFormativo;
    }

    public function trabajar() {
        return "Soy un estudiante de FP en el ciclo $this->cicloFormativo y estoy estudiando.";
    }

    public function __toString() {
        return parent::__toString() . ", Ciclo Formativo: $this->cicloFormativo";
    }
}
?>