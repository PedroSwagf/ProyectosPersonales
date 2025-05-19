-- Creamos la base de datos
create database practicaUnidad5;
-- La seleccionamos
use practicaUnidad5;
-- Reutilizamos el usuario gestro que ya teniamos (Podemos crear otro)
grant all on practicaUnidad5.* to gestor@'localhost';
-- Creamos las Tablas --
create table jugadores(
    id int auto_increment primary key,
    nombre varchar(40) not null,
    apellidos varchar(60) not null,
    dorsal int unique,
    posicion enum('Portero', 'Defensa', 'Lateral Izquierdo', 'Lateral Derecho', 'Central', 'Delantero'),
    codigo_barras varchar(13) unique not null
);
ALTER TABLE jugadores ADD COLUMN ruta_imagen VARCHAR(255);

-- ## Insertamos Algunos datos, descomentar si no te ha funcionado  fazinotto/faker ##
INSERT INTO jugadores (nombre, apellidos, dorsal, posicion, codigo_barras, ruta_imagen) 
VALUES 
    ('Antonio', 'Gil Gil', 1, 'Portero', '0952945303398', 'barcodes/0952945303398.jpg'),
    ('Ana', 'Hernandez Perez', 2, 'Defensa', '2406603743234', 'barcodes/2406603743234.jpg'),
    ('Juan', 'Valdemoro Gil', 3, 'Defensa', '2829114057100', 'barcodes/2829114057100.jpg'),
    ('Maria', 'Ruano Perez', 4, 'Defensa', '9745708466710', 'barcodes/9745708466710.jpg');
