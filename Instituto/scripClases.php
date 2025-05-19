<?php
require_once 'instituto.php'; 

// Contador para cada clase
$contadores = [
    'Administrativo' => 0,
    'Conserjes' => 0,
    'Plimpieza' => 0,
    'Profesorado' => 0,
    'Alumno ESO' => 0,
    'Alumno Bachillerato' => 0,
    'Alumno FP' => 0,
];

// Array para almacenar los objetos creados
$objetos = [];

// Materias posibles para el profesorado
$materiasPosibles = ['Matemáticas', 'Física', 'Química', 'Lenguas', 'Historia'];

// Generar 100 objetos aleatorios
for ($i = 0; $i < 100; $i++) {
    // Generar un tipo de clase al azar
    $tipos = array_keys($contadores);
    $tipo = $tipos[array_rand($tipos)];

    // Crear el objeto correspondiente y añadirlo al array
    switch ($tipo) {
        case 'Administrativo':
            $objetos[] = new Administrativo(
                "Nombre$i",
                "Apellido1$i",
                "Apellido2$i",
                strtoupper(bin2hex(random_bytes(4))),
                rand(600000000, 699999999),
                "Calle Falsa $i",
                "Masculino",
                rand(1, 30)
            );
            break;
        case 'Conserjes':
            $objetos[] = new Conserjes(
                "Nombre$i",
                "Apellido1$i",
                "Apellido2$i",
                strtoupper(bin2hex(random_bytes(4))),
                rand(600000000, 699999999),
                "Calle Falsa $i",
                "Femenino",
                rand(1, 30)
            );
            break;
        case 'Plimpieza':
            $objetos[] = new Plimpieza(
                "Nombre$i",
                "Apellido1$i",
                "Apellido2$i",
                strtoupper(bin2hex(random_bytes(4))),
                rand(600000000, 699999999),
                "Calle Falsa $i",
                "Masculino",
                rand(1, 30)
            );
            break;
        case 'Profesorado':
            $objetos[] = new Profesora(
                "Nombre$i",
                "Apellido1$i",
                "Apellido2$i",
                strtoupper(bin2hex(random_bytes(4))),
                rand(600000000, 699999999),
                "Calle Falsa $i",
                "Femenino",
                rand(1, 30),
                [$materiasPosibles[array_rand($materiasPosibles)]],
                "vicedireccion"
            );
            break;
        case 'Alumno ESO':
            $objetos[] = new Alumno(
                "Nombre$i",
                "Apellido1$i",
                "Apellido2$i",
                strtoupper(bin2hex(random_bytes(4))),
                rand(600000000, 699999999),
                "Calle Falsa $i",
                "Masculino",
                "ESO",
                "A"
            );
            break;
        case 'Alumno Bachillerato':
            $objetos[] = new AlumnoBachillerato(
                "Nombre$i",
                "Apellido1$i",
                "Apellido2$i",
                strtoupper(bin2hex(random_bytes(4))),
                rand(600000000, 699999999),
                "Calle Falsa $i",
                "Femenino",
                "Bachillerato",
                "B"
            );
            break;
        case 'Alumno FP':
            $objetos[] = new AlumnoFP(
                "Nombre$i",
                "Apellido1$i",
                "Apellido2$i",
                strtoupper(bin2hex(random_bytes(4))),
                rand(600000000, 699999999),
                "Calle Falsa $i",
                "Masculino",
                "FP",
                "C",
                "Informática"
            );
            break;
    }

    // Incrementar el contador del tipo correspondiente
    $contadores[$tipo]++;
}

// Mostrar el número de objetos creados de cada clase
echo "<h2>Número de objetos creados por clase:</h2>";
foreach ($contadores as $tipo => $cantidad) {
    echo "<p>$tipo: $cantidad</p>";
}

// Invocar el método trabajar() para cada objeto
echo "<h2>Trabajos realizados:</h2>";
foreach ($objetos as $objeto) {
    echo "<p>" . $objeto->trabajar() . "</p>";
}
?>
