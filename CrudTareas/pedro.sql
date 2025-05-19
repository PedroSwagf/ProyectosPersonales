
DROP DATABASE if exists pedroDB;

create database if not exists pedroDB;
use pedroDB;

create table if not exists usuarios (
    nombreUsuario varchar (50) primary key,
    contraseña varchar (255) not null,
    nombre varchar (50),
    apellidos varchar (50),
    idCargo int
);
create table if not exists tareas(
    idTarea int not null auto_increment primary key,
    nombre varchar(100),
    fechaInicio date,
    fechaEntrega date,
    descripcion varchar(100),
    idProyecto int
);
create table if not exists cargos (
    idCargo int not null auto_increment primary key,
    nombreCargo varchar (50)
);

create table if not exists usuariosTarea (
    idUsuario varchar (50),
    idTarea int,
    primary key (idUsuario, idTarea)
);

create table if not exists proyectos (
    idProyecto int auto_increment primary key,
    nombreProyecto varchar (50),
    descripcion varchar(300),
    idCoord varchar (50)
);

ALTER TABLE usuariosTarea ADD CONSTRAINT usuario_fk FOREIGN KEY (idUsuario) REFERENCES usuarios(nombreUsuario) ON DELETE CASCADE;
ALTER TABLE usuariosTarea ADD CONSTRAINT tarea_fk FOREIGN KEY (idTarea) REFERENCES tareas(idTarea) ON DELETE CASCADE;
ALTER TABLE proyectos ADD CONSTRAINT coordinador_fk FOREIGN KEY (idCoord) REFERENCES usuarios(nombreUsuario) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE usuarios ADD CONSTRAINT idCargo_fk FOREIGN KEY (idCargo) REFERENCES cargos(idCargo) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE tareas ADD CONSTRAINT idProyecto_fk FOREIGN KEY (idProyecto) REFERENCES proyectos(idProyecto) ON DELETE SET NULL ON UPDATE CASCADE;

INSERT INTO cargos (nombreCargo) VALUES
('Administrador'),
('Coordinador'),
('Usuario');

INSERT INTO usuarios (nombreUsuario, contraseña, nombre, apellidos, idCargo) VALUES
('Administrador', '$2y$10$ntn72hKlsbezbXZ5tdCm5uuzCeDEvgG.FCI3ii3c73qIajYIcfoXO', 'Pedro', 'Fernandez',1),
('Coordinador', '$2y$10$ntn72hKlsbezbXZ5tdCm5uuzCeDEvgG.FCI3ii3c73qIajYIcfoXO', 'Ruben', 'Alvarez',2),
('Coordinador2', '$2y$10$ntn72hKlsbezbXZ5tdCm5uuzCeDEvgG.FCI3ii3c73qIajYIcfoXO', 'Paquita', 'La del barrio',2),
('julio', '$2y$10$ntn72hKlsbezbXZ5tdCm5uuzCeDEvgG.FCI3ii3c73qIajYIcfoXO', 'julio', 'Gomez',3),
('daniel', '$2y$10$ntn72hKlsbezbXZ5tdCm5uuzCeDEvgG.FCI3ii3c73qIajYIcfoXO', 'Daniel', 'Otero',3);


INSERT INTO proyectos (idProyecto,nombreProyecto, descripcion, idCoord) VALUES
(1,'Proyecto 1', 'Descripción del Proyecto 1', 'Coordinador'),
(2,'Proyecto 2', 'Descripción del Proyecto 2', 'Coordinador'),
(3,'Proyecto 3', 'Descripción del Proyecto 3', 'Coordinador2');

INSERT INTO tareas (idTarea,nombre,fechaInicio,fechaEntrega,descripcion,idProyecto) VALUES
(1,'tarea1','2024-12-22','2024-12-23','messi',1),
(2,'tarea2','2024-11-22','2024-11-23','cristiano',2),
(3,'tarea3','2024-10-22','2024-10-23','reus',3);

INSERT INTO usuariosTarea (idUsuario,idTarea) VALUES
('julio',1),
('julio',2),
('daniel',2),
('julio',3);


