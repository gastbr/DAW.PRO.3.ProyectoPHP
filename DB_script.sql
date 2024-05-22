drop database if exists albergue;
create database albergue;
use albergue;

CREATE TABLE usuario (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(15) NOT NULL UNIQUE,
    Email VARCHAR(30) NOT NULL UNIQUE,
    Pass VARCHAR(30) NOT NULL,
    Tipo ENUM('Coordinador', 'Anfitrión')
);

CREATE TABLE anfitrion (
    DNI CHAR(9) PRIMARY KEY,
    Nombre VARCHAR(15) NOT NULL,
    Apellido1 VARCHAR(15) NOT NULL,
    Apellido2 VARCHAR(15),
    Telefono CHAR(9) NOT NULL,
    Direccion VARCHAR(255) NOT NULL,
    Disponibilidad VARCHAR(15),
    Usuario INT,
    CONSTRAINT check_Anfitrion_DNI CHECK (DNI RLIKE '^[0-9]+[a-z]$'),
    CONSTRAINT check_Anfitrion_Telefono CHECK (Telefono RLIKE '^[0-9]$'),
    CONSTRAINT FK_Anfitrion_Usuario FOREIGN KEY (Usuario)
        REFERENCES usuario(ID)
);

CREATE TABLE mascota (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(15) NOT NULL,
    Raza VARCHAR(15) NOT NULL,
    Tamanio ENUM('Grande', 'Pequeño', 'Mediano') NOT NULL,
    FechaEntrada DATE NOT NULL,
    FechaSalida DATE,
    FechaNacimiento DATE,
    Sexo ENUM('Macho', 'Hembra') NOT NULL,
    Foto VARCHAR(255),
    Descripcion VARCHAR(255)
);

CREATE TABLE anfitrion_acoge_mascota (
    Anfitrion CHAR(9),
    Mascota INT,
    CONSTRAINT FK_acoge_anfitrion FOREIGN KEY (anfitrion)
        REFERENCES anfitrion (DNI),
    CONSTRAINT FK_acoge_mascota FOREIGN KEY (mascota)
        REFERENCES mascota (ID)
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
    CONSTRAINT check_Visita_Telefono CHECK (TelefonoVisitante RLIKE '^[0-9]$')
);

CREATE TABLE anfitrion_recibe_visita (
    anfitrion CHAR(9),
    visita INT,
    CONSTRAINT FK_recibe_anfitrion FOREIGN KEY (anfitrion)
        REFERENCES anfitrion (DNI),
    CONSTRAINT FK_recibe_visita FOREIGN KEY (visita)
        REFERENCES visita (ID)
);

CREATE TABLE voluntario (
    DNI CHAR(9) PRIMARY KEY,
    Nombre VARCHAR(15) NOT NULL,
    Apellido1 VARCHAR(15) NOT NULL,
    Apellido2 VARCHAR(15),
    Telefono CHAR(9) NOT NULL,
    Disponibilidad VARCHAR(15),
    CONSTRAINT check_Voluntario_DNI CHECK (DNI RLIKE '^[0-9]+[a-z]$'),
    CONSTRAINT check_Voluntario_Telefono CHECK (Telefono RLIKE '^[0-9]$')
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
        REFERENCES Tarea (ID),
    CONSTRAINT FK_Realiza_Voluntario FOREIGN KEY (voluntario)
        REFERENCES Voluntario (DNI)
);

CREATE TABLE donacion (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    NombreDonante VARCHAR(40),
    Importe DECIMAL(7 , 2 ) UNSIGNED
);