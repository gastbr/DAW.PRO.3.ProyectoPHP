<?php
$mysqli = new mysqli("localhost:3307", "root", "", "albergue");
if (!$mysqli) {
    die("No se pudo conectar a la BBDD: " . mysqli_connect_error());
}

#region ANFITRIÓN

if (isset($_GET["anfitrion"])) {

    $email = $_POST["email"];
    $username = $_POST["username"];
    $pass = md5($_POST["pass"]);
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

    #region Alta
    if ($_GET["anfitrion"] == "alta") {
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
}

#region MASCOTA

if (isset($_GET["mascota"]) && $_GET["mascota"] == "editar") {

    $nombreMascota = $_POST['nombre'];
    $razaMascota = $_POST['raza'];
    $tamanioMascota = $_POST['tamanio'];
    $nacimientoMascota = $_POST['nacimiento'];
    $sexoMascota = $_POST['sexo'];
    $descripcionMascota = $_POST['descripcion'];
    $id = $_POST['id'];

    #region Edición

    $query = "UPDATE albergue.mascota SET
            Nombre = '$nombreMascota',
            Raza = '$razaMascota',
            Tamanio = '$tamanioMascota',
            FechaNacimiento = '$nacimientoMascota',
            Sexo = '$sexoMascota',
            Descripcion = nullif('$descripcionMascota', '')
        WHERE id = $id;";
    $mysqli->query($query);
    header("Location: ../admin/inicio_admin.php?modMascota=$id");
    exit();
}

#region Alta

if (isset($_GET["mascota"]) && $_GET["mascota"] == "alta") {
    // Alta mascota: comprobar anfitrión
    $idAnfitrion = $_POST['dni_acogida'];
    $existeAnfitrion = "";

    if (isset($_POST["localizacion"]) && $_POST["localizacion"] == "Acogida") {
        $query = "SELECT EXISTS(SELECT DNI FROM albergue.anfitrion WHERE DNI = '$idAnfitrion') as 'result';";
        $existeAnfitrion = $mysqli->query($query)->fetch_assoc()['result'];
        $localizacion = "Acogida";

        if ($existeAnfitrion == 0) {
            echo "Anfitrion no existente.";
            header("Location: ../admin/alta_mascota.php?opcion=anfitrion_notfound");
            exit();
        }
    } else if (isset($_POST["localizacion"]) && $_POST["localizacion"] == "Albergue") {
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
    $table = $mysqli->query($query);
    $query = "SELECT * FROM albergue.anfitrion_acoge_mascota WHERE mascota=$idMascota;";
    $tableAnfitrion = $mysqli->query($query);
}

#region BAJAS

if (isset($_GET['bajaMascota'])) {
    $id = $_GET['bajaMascota'];
    $query = "DELETE FROM albergue.mascota WHERE ID = '$id'";
    $mysqli->query($query);
}

if (isset($_GET['bajaAnfitrion'])) {
    $id = $_GET['bajaAnfitrion'];
    $query = "SELECT usuario FROM albergue.anfitrion WHERE dni = '$id'";
    $tabla = $mysqli->query($query);
    $usuario = $tabla->fetch_all(MYSQLI_ASSOC)[0]['usuario'];

    $query = "DELETE FROM albergue.anfitrion WHERE DNI = '$id';";
    $mysqli->query($query);

    $query = "DELETE FROM albergue.usuario WHERE username = '$usuario';";
    $mysqli->query($query);
}

#region BUSCADOR

if (isset($_GET['busca']) && $_GET['busca'] == 'mascota' && isset($_POST['buscar'])) {
    $buscar = trim($_POST['buscar']);
    if ($buscar == "") {
        $query = "SELECT * FROM albergue.mascota;";
    } else if ($buscar != "") {
        $query = "SELECT * from albergue.mascota where id = '$buscar' OR nombre LIKE '%$buscar%'";
    }
    $table = $mysqli->query($query);
}

if (isset($_GET['busca']) && $_GET['busca'] == 'anfitrion' && isset($_POST['buscar'])) {
    $buscar = trim($_POST['buscar']);
    if ($buscar == "") {
        $query = "SELECT * FROM albergue.anfitrion;";
    } else if ($buscar != "") {
        $query = "SELECT * from albergue.anfitrion where DNI = '$buscar' OR nombre LIKE '%$buscar%' OR apellido1 LIKE '%$buscar%' OR apellido2 LIKE '%$buscar%'";
    }
    $table = $mysqli->query($query);
}

#region inicio_anfitiron

if (
    isset($_SESSION['loc']) &&
    $_SESSION['loc'] == 'inicio_anfitrion' &&
    isset($_SESSION['admin']) &&
    !$_SESSION['admin']
) {

    $user = $_SESSION['user'];

    // Datos del anfitrion
    $query = "SELECT * FROM albergue.anfitrion WHERE usuario = '$user'";
    $tablaAnfitrion = $mysqli->query($query);
    $rowAnfitrion = $tablaAnfitrion->fetch_all(MYSQLI_ASSOC)[0];

    $dni = $rowAnfitrion['DNI'];

    // Comprueba si tiene mascota
    $query = "SELECT EXISTS(SELECT ANFITRION from albergue.anfitrion_acoge_mascota where anfitrion = '$dni') as 'tieneMascota';";
    $tieneMascota = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC)[0]['tieneMascota'];

    // Datos de la mascota
    if ($tieneMascota) {
        $query = "SELECT * FROM albergue.mascota WHERE id = (SELECT mascota FROM albergue.anfitrion_acoge_mascota WHERE anfitrion = '$dni');";
        $tablaMascota = $mysqli->query($query);
    }
}

if (isset($_GET['pdf'])) {
    if (!class_exists('FPDF')) {
        require_once('../../fpdf186/fpdf.php');
    }

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetTitle("Anfitriones");
    $pdf->SetFont('Arial', 'B', 10);

    if ($_GET['pdf'] == 'anfitriones') {
        $pdf->Cell(20, 10, 'DNI', 1, 0, 'C');
        // Header cell (width, height, text, border, line break, alignment)
        $pdf->Cell(30, 10, 'Nombre', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Apellido1', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Apellido2', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Telefono', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Username', 1, 1, 'C');
        // Last cell with line break

        $pdf->SetFont('Arial', '', 8);
        // Set font for data rows

        $query = "SELECT * from albergue.anfitrion;";
        $table = $mysqli->query($query);

        while ($row = $table->fetch_assoc()) {
            $pdf->Cell(20, 10, $row['DNI'], 1, 0);
            $pdf->Cell(30, 10, $row['Nombre'], 1, 0);
            $pdf->Cell(30, 10, $row['Apellido1'], 1, 0);
            $pdf->Cell(30, 10, $row['Apellido2'], 1, 0);
            $pdf->Cell(30, 10, $row['Telefono'], 1, 0);
            $pdf->Cell(30, 10, $row['Usuario'], 1, 1);
        }
    }

    if ($_GET['pdf'] == 'mascotas') {
        $pdf->Cell(20, 10, 'ID', 1, 0, 'C');
        // Header cell (width, height, text, border, line break, alignment)
        $pdf->Cell(30, 10, 'Nombre', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Raza', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Tamanio', 1, 0, 'C');
        $pdf->Cell(30, 10, 'FechaNacimiento', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Descripcion', 1, 1, 'L');
        // Last cell with line break

        $pdf->SetFont('Arial', '', 8);
        // Set font for data rows

        $query = "SELECT * from albergue.mascota;";
        $table = $mysqli->query($query);

        while ($row = $table->fetch_assoc()) {
            $pdf->Cell(20, 10, $row['ID'], 1, 0);
            $pdf->Cell(30, 10, $row['Nombre'], 1, 0);
            $pdf->Cell(30, 10, $row['Raza'], 1, 0);
            $pdf->Cell(30, 10, $row['Tamanio'], 1, 0);
            $pdf->Cell(30, 10, $row['FechaNacimiento'], 1, 0);
            $pdf->Cell(30, 10, $row['Descripcion'], 1, 1);
        }
    }
    $pdf->Output('data_export.pdf', 'D');
}
