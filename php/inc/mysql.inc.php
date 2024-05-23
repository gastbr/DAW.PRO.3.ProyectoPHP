<?php

$mysqli = new mysqli("localhost:3307", "root", "", "albergue");
if (!$mysqli) {
    die("No se pudo conectar a la BBDD: " . mysqli_connect_error());
}

// ALTA MASCOTA

if (isset($_GET["opcion"]) && $_GET["opcion"] == "alta_mascota") {
    $nombreMascota = $_POST['nombre'];
    $razaMascota = $_POST['raza'];
    $tamanioMascota = $_POST['tamanio'];
    $nacimientoMascota = $_POST['nacimiento'];
    $sexoMascota = $_POST['sexo'];
    $descripcionMascota = $_POST['descripcion'];

    $query = "INSERT INTO mascota
    (nombre, raza, tamanio, fechanacimiento, sexo, descripcion) values(
        nullif('$nombreMascota', ''),
        nullif('$razaMascota', ''),
        nullif('$tamanioMascota', ''),
        nullif('$nacimientoMascota', ''),
        nullif('$sexoMascota', ''),
        nullif('$descripcionMascota', ''));";

    $mysqli->query($query);

    $table = $mysqli->query("SELECT id FROM mascota where nombre = '$nombreMascota';");

    $idMascota = $table->fetch_assoc()['id'];

    // Alta mascota: guardar foto

    if (isset($_FILES["foto"])) {
        $fotoMascota = $_FILES["foto"];
        $formato = $fotoMascota["type"];

        if ($formato == "image/jpeg" || $formato == "image/jpg" || $formato == "image/png") {
            switch ($formato) {
                case "image/png":
                    $fileName = "fotoMascota-ID$idMascota.png";
                    break;
                case "image/jpg":
                    $fileName = "fotoMascota-ID$idMascota.jpg";
                    break;
                case "image/jpeg":
                    $fileName = "fotoMascota-ID$idMascota.jpeg";
                    break;
                default:
                    echo "Formato de archivo no válido.";
            }
            move_uploaded_file($fotoMascota['tmp_name'], "../../mediabd/$fileName");
            $mysqli->query("UPDATE mascota SET foto = '../../mediabd/$fileName' WHERE id = $idMascota;");
        } else {
            echo "Formato de archivo no válido.";
        }
    }

    // Alta mascota: asociar con anfitrión (si lo tiene)

    if ($_POST["localizacion"] == "acogida") {
        
    }

    header("Location: ../admin/alta_mascota.php?opcion=alta_ok");
    exit();
}