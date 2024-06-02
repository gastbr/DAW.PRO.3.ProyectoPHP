<?php
include '../inc/func.inc.php';
include '../inc/mysql.inc.php';
HeadHTML();
?>

<main class="container mt-2 mx-3">
    <a href="../index.php" type="button" class="btn btn-outline-success">Ver lsitado público</a>
    <a href="alta_anfitrion.php" type="button" class="btn btn-success">Alta de anfitriones</a>
    <a href="alta_mascota.php" type="button" class="btn btn-success">Alta de mascotas</a>
    <a href="../inc/login.inc.php?session=logout" type="button" class="btn btn-danger">Cerrar la sesión</a>
</main>

<?php
FooterHTML();
?>