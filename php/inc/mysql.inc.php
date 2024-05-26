<?php

$mysqli = new mysqli("localhost:3307", "root", "", "albergue");
if (!$mysqli) {
    die("No se pudo conectar a la BBDD: " . mysqli_connect_error());
}

// ALTA ANFITRIÓN

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

    $aDispHora = $_POST["dispHora"][1];
    $aDispDia = $_POST["dispDia"][1];

    /*     
    for ($i = 0; $i < count($aDispHora); $i++) {
        $dispHora =$dispHora."-".$aDispHora[$i];
    }

    for ($i = 0; $i < count($aDispDia); $i++) {
        $dispDia = $dispDia."-".$aDispDia[$i];
    }
    */

    $disponibilidad = $dispHora . "/" . $dispDia;

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

// ALTA MASCOTA

if (isset($_GET["opcion"]) && $_GET["opcion"] == "alta_mascota") {
    // Alta mascota: comprobar anfitrión
    $idAnfitrion = $_POST['dni_acogida'];
    $result;

    if (isset($_POST["localizacion"]) && $_POST["localizacion"] == "acogida") {
        $query = "SELECT EXISTS(SELECT DNI FROM albergue.anfitrion WHERE DNI = '$idAnfitrion') as 'resultado';";
        $result = $mysqli->query($query)->fetch_assoc();

        if ($result['resultado'] == 0) {
            echo "Anfitrion no existente.";
            header("Location: ../admin/alta_mascota.php?opcion=anfitrion_notfound");
            exit();
        }
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
            $mysqli->query("UPDATE mascota SET foto = '../../mediabd/$fileName' WHERE id = $idMascota;");
        } else {
            echo "Formato de archivo no válido.";
        }
    }

    // Alta mascota: insertar relacion con anfitrión

    if (isset($_POST["localizacion"]) && $_POST["localizacion"] == "acogida" && $result['resultado'] == 1) {
        $query = "INSERT INTO albergue.anfitrion_acoge_mascota VALUES ($idMascota, $idAnfitrion);";
        $mysqli->query($query);
    }

    header("Location: ../admin/alta_mascota.php?opcion=alta_ok");
    exit();
}
