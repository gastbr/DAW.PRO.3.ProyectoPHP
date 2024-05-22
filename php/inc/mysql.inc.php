<?php

$mysqli = new mysqli("localhost:3307", "root", "", "albergue");
if (!$mysqli) {
    die("No se pudo conectar a la BBDD: " . mysqli_connect_error());
}

// ALTA MASCOTA

if (isset($_GET["opcion"]) && $_GET["opcion"] == 'alta_mascota') {
    $nombreMascota = $_POST['nombre'];
    $razaMascota = $_POST['raza'];
    $tamanioMascota = $_POST['tamanio'];
    $nacimientoMascota = $_POST['nacimiento'];
    $sexoMascota = $_POST['sexo'];
    $localizacionMascota = $_POST['localizacion'];
    $descripcionMascota = $_POST['descripcion'];
    $fotoMascota = $_POST['foto'];
    $dniAcogidaMascota = $_POST['dni_acogida'];


    
    $query = "INSERT INTO mascota (nombre, raza, tamanio, fechanacimiento, sexo, foto, descripcion)";
    $mysqli->query($query);
}

