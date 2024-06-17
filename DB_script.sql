drop database if exists albergue;
create database albergue;
use albergue;

CREATE TABLE usuario (
    Username VARCHAR(15) PRIMARY KEY,
    Email VARCHAR(30) NOT NULL UNIQUE,
    Pass VARCHAR(255) NOT NULL,
    Tipo ENUM('Coordinador', 'Anfitrión')
);

CREATE TABLE anfitrion (
    DNI CHAR(9) PRIMARY KEY,
    Nombre VARCHAR(15) NOT NULL,
    Apellido1 VARCHAR(15) NOT NULL,
    Apellido2 VARCHAR(15),
    Telefono CHAR(9) NOT NULL,
    Direccion VARCHAR(255) NOT NULL,
    Disponibilidad VARCHAR(100),
    Usuario VARCHAR(15),
    CONSTRAINT check_Anfitrion_DNI CHECK (DNI RLIKE '^[0-9]+[a-z]$'),
    CONSTRAINT check_Anfitrion_Telefono CHECK (Telefono RLIKE '^[0-9]{9}$'),
    CONSTRAINT FK_Anfitrion_Usuario FOREIGN KEY (Usuario)
        REFERENCES usuario(Username) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE mascota (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(15) NOT NULL UNIQUE,
    Raza VARCHAR(20) NOT NULL,
    Tamanio ENUM('Grande', 'Pequeño', 'Mediano') NOT NULL,
    FechaRegistro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FechaSalida DATE,
    FechaNacimiento DATE,
    Sexo ENUM('Macho', 'Hembra') NOT NULL,
    Localizacion ENUM('albergue', 'acogida') NOT NULL,
    Foto VARCHAR(255),
    Descripcion VARCHAR(255)
);

CREATE TABLE anfitrion_acoge_mascota (
    Mascota INT primary key,
    Anfitrion CHAR(9),
    CONSTRAINT FK_acoge_anfitrion FOREIGN KEY (anfitrion)
        REFERENCES anfitrion (DNI) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_acoge_mascota FOREIGN KEY (mascota)
        REFERENCES mascota (ID) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Visita (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    fechaHora DATETIME NOT NULL UNIQUE,
    Mascota INT,
    Anfitrion CHAR(9),
    TipoVisita ENUM('Anfitrión', 'Albergue') NOT NULL,
    NombreVisitante VARCHAR(30) NOT NULL,
    TelefonoVisitante CHAR(9) NOT NULL,
    EmailVisitante VARCHAR(30) NOT NULL,
    Comentarios VARCHAR(100),
    CONSTRAINT check_Visita_Telefono CHECK (TelefonoVisitante RLIKE '^[0-9]{9}$')
);

CREATE TABLE anfitrion_recibe_visita (
    anfitrion CHAR(9),
    visita INT,
    CONSTRAINT FK_recibe_anfitrion FOREIGN KEY (anfitrion)
        REFERENCES anfitrion (DNI) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_recibe_visita FOREIGN KEY (visita)
        REFERENCES visita (ID) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE voluntario (
    DNI CHAR(9) PRIMARY KEY,
    Nombre VARCHAR(15) NOT NULL,
    Apellido1 VARCHAR(15) NOT NULL,
    Apellido2 VARCHAR(15),
    Telefono CHAR(9) NOT NULL,
    Disponibilidad VARCHAR(15),
    CONSTRAINT check_Voluntario_DNI CHECK (DNI RLIKE '^[0-9]+[a-z]$'),
    CONSTRAINT check_Voluntario_Telefono CHECK (Telefono RLIKE '^[0-9]{9}$')
);

CREATE TABLE tarea (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    FechaHora DATETIME NOT NULL,
    Descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE Voluntario_Realiza_Tarea (
    Tarea INT,
    voluntario CHAR(9),
    HorasRealizadas TINYINT UNSIGNED,
    CONSTRAINT FK_Realiza_Tarea FOREIGN KEY (Tarea)
        REFERENCES Tarea (ID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_Realiza_Voluntario FOREIGN KEY (voluntario)
        REFERENCES Voluntario (DNI) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE donacion (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    NombreDonante VARCHAR(40),
    Importe DECIMAL(7 , 2 ) UNSIGNED
);

insert into albergue.usuario values ('usuario1','correo1@email.com',md5('1234'),2);
insert into albergue.usuario values ('usuario2','correo2@email.com',md5('1234'),2);
insert into albergue.usuario values ('usuario3','correo3@email.com',md5('1234'),2);
insert into albergue.usuario values ('usuarioPep','pepguar@email.com',md5('1234'),2);
insert into albergue.usuario values ('admin','admin@email.com',md5('1234'),1);
insert into albergue.anfitrion values ('78599964V','Cristiano','Messi','Neymar', '712345689','Calle Falsa 123','Mañana-Tarde-L-M-X-J-V-S-D','usuario1');
insert into albergue.anfitrion values ('78945612P','Lionel','Ronaldo','Jr.','654987545','Calle Real 987','Mañana-L-M-X-S-D','usuario2');
insert into albergue.anfitrion values ('32165487U','Andrés','Iniesta','Ronaldinho','789456321','Calle Uno 654','Tarde-L-S-D','usuario3');
insert into albergue.anfitrion values ('57845698P','Pep','Guardiola','Messi','684597541','Lololol 387','Tarde-L-D','usuarioPep');

INSERT INTO `mascota` VALUES
(1,'Ambrosio','Labrador','Grande','2024-05-27 03:24:59',NULL,'2024-03-19','Macho','Albergue','fotoMascota-ID1.jpg','Descripción del bueno de Ambrosio.'),
(2,'Petunia','Pastor Aleman','Mediano','2024-05-27 03:26:34',NULL,'2024-03-20','Hembra','Albergue','fotoMascota-ID2.jpeg','Petunia es una perrita muy alegre, siempre lista para jugar y divertirse. Su cola no deja de menearse, contagiando su entusiasmo a todos los que la rodean. Sus ojos, llenos de brillo y vivacidad, reflejan su espíritu juguetón. Adora corretear por el parqu'),
(3,'Gerardo','Pinscher','Pequeño','2024-05-27 03:28:28',NULL,'2023-06-27','Hembra','Albergue','fotoMascota-ID3.jpg','Gerardo es un perrito muy cariñoso y afable, con un corazón tan grande como su pelaje esponjoso. Su mirada tierna y bondadosa derrite cualquier corazón, y su cola siempre menea con entusiasmo al recibir a sus seres queridos. Adora acurrucarse en el sofá j'),
(4,'Mambo','Bardino','Mediano','2024-05-27 03:29:31',NULL,'2024-02-06','Macho','Albergue','fotoMascota-ID4.jpg','Mambo es muy inteligente.'),
(5,'Trombón','Labrador','Grande','2024-05-27 03:30:12',NULL,'2023-05-27','Hembra','Albergue','fotoMascota-ID5.jpg','Trombón es muy buen chico.'),
(6,'Maracaibo','Chihuahua','Pequeño','2024-05-27 03:31:02',NULL,'2022-05-27','Hembra','Albergue','fotoMascota-ID6.jpg','Maracaibo (en wayú: Marakaaya) es la ciudad capital del estado Zulia, ubicada en el noroeste de Venezuela. Fundada en 1529 por Ambrosio Alfinger como Nueva Núremberg (hispanización de Neu Nürnberg, en alemán) en homenaje a la ciudad alemana Núremberg. Es '),
(7,'Quesito','Pastor Belga','Grande','2024-05-27 03:53:18',NULL,'2024-03-10','Hembra','Acogida',NULL,'Quesito es muy guapa, pero no tiene foto. Queríamos probar cómo se veía la web si no había foto.');

INSERT INTO albergue.anfitrion_acoge_mascota VALUES ('7', '78599964V');