<?php

$mysqli = new mysqli("localhost:3307", "root", "", "albergue");
if (!$mysqli) {
    die("No se pudo conectar a la BBDD: " . mysqli_connect_error());
}

#region ALTA ANFITRIÓN

if (isset($_GET["opcion"]) && $_GET["opcion"] == "alta_anfitrion") {
    $email = $_POST["email"];
    $username = $_POST["username"];
    $pass = $_POST["pass"];
    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $apellido1 = $_POST["apellido1"];
    $apellido2 = $_POST["apellido2"];
    $tel = $_POST["tel"];
    $dir = $_POST["dir"];

    $disponibilidad = "-";

    if (isset($_POST["Mañana"])) {
        $disponibilidad = "Mañana-";
    }
    if (isset($_POST["Tarde"])) {
        $disponibilidad = $disponibilidad . "Tarde-";
    }
    if (isset($_POST["L"])) {
        $disponibilidad = $disponibilidad . "L-";
    }
    if (isset($_POST["M"])) {
        $disponibilidad = $disponibilidad . "M-";
    }
    if (isset($_POST["X"])) {
        $disponibilidad = $disponibilidad . "X-";
    }
    if (isset($_POST["J"])) {
        $disponibilidad = $disponibilidad . "J-";
    }
    if (isset($_POST["V"])) {
        $disponibilidad = $disponibilidad . "V-";
    }
    if (isset($_POST["S"])) {
        $disponibilidad = $disponibilidad . "S-";
    }
    if (isset($_POST["D"])) {
        $disponibilidad = $disponibilidad . "D-";
    }

    $disponibilidad = rtrim($disponibilidad, "-");

    $query = "INSERT INTO albergue.usuario VALUES (
        '$username',
        '$email',
        '$pass',
        'Anfitrión');";
    $mysqli->query("$query");

    $query = "INSERT INTO albergue.anfitrion VALUES (
        '$dni',
        '$nombre',
        '$apellido1',
        nullif('$apellido2', ''),
        '$tel',
        '$dir',
        nullif('$disponibilidad', ''),
        '$username');";
    $mysqli->query("$query");

    header("Location: ../admin/alta_anfitrion.php?opcion=alta_ok");
    exit();
}

#region ALTA MASCOTA

if (isset($_GET["opcion"]) && $_GET["opcion"] == "alta_mascota") {
    // Alta mascota: comprobar anfitrión
    $idAnfitrion = $_POST['dni_acogida'];
    $existeAnfitrion = "";

    if (isset($_POST["localizacion"]) && $_POST["localizacion"] == "acogida") {
        $query = "SELECT EXISTS(SELECT DNI FROM albergue.anfitrion WHERE DNI = '$idAnfitrion') as 'result';";
        $existeAnfitrion = $mysqli->query($query)->fetch_assoc()['result'];
        $localizacion = "Acogida";

        if ($existeAnfitrion == 0) {
            echo "Anfitrion no existente.";
            header("Location: ../admin/alta_mascota.php?opcion=anfitrion_notfound");
            exit();
        }
    } else if (isset($_POST["localizacion"]) && $_POST["localizacion"] == "albergue") {
        $localizacion = "Albergue";
    }

    // Alta mascota: guardar datos

    $nombreMascota = $_POST['nombre'];
    $razaMascota = $_POST['raza'];
    $tamanioMascota = $_POST['tamanio'];
    $nacimientoMascota = $_POST['nacimiento'];
    $sexoMascota = $_POST['sexo'];
    $descripcionMascota = $_POST['descripcion'];

    $query = "INSERT INTO mascota
    (nombre, raza, tamanio, fechanacimiento, sexo, localizacion, descripcion) values(
        '$nombreMascota',
        '$razaMascota',
        '$tamanioMascota',
        '$nacimientoMascota',
        '$sexoMascota',
        '$localizacion',
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
            $mysqli->query("UPDATE mascota SET foto = '$fileName' WHERE id = $idMascota;");
        } else {
            echo "Formato de archivo no válido.";
        }
    }

    // Alta mascota: insertar relacion con anfitrión

    if ($existeAnfitrion == 1) {
        $query = "INSERT INTO albergue.anfitrion_acoge_mascota VALUES ($idMascota, '$idAnfitrion');";
        $mysqli->query($query);
    }

    header("Location: ../admin/alta_mascota.php?altaMascota=$nombreMascota");
    exit();
}

#region SELECT MASCOTAS

if (isset($_GET["idMascota"])) {
    $idMascota = $_GET["idMascota"];
    $query = "SELECT * FROM albergue.mascota WHERE id=$idMascota;";
} else {
    $query = "SELECT * FROM albergue.mascota;";
}

$table = $mysqli->query($query);
