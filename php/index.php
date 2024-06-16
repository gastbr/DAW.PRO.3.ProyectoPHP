<?php
include 'inc/func.inc.php';
include 'inc/mysql.inc.php';
HeadHTML();
$query = "SELECT * FROM albergue.mascota;";
$table = $mysqli->query($query);
?>
<main>
    <a href="login.php" class="btn btn-success mt-2 mx-4">Admin login</a>
    <span id="logout" class="text-danger fw-bold d-none">La sesión se ha cerrado con éxito.</span>
    <span id="denegado" class="text-danger fw-bold d-none">Acceso denegado.</span>

    <section class="container">

        <?php while ($row = $table->fetch_assoc()) { ?>
            <div id="id<?php echo $row["ID"] ?>" class="card d-inline-block m-3 align-top">
                <img src="../mediabd/<?php echo $row["Foto"] ?>" alt="Imagen del perro <?php echo $row["ID"] ?>" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row["Nombre"] ?></h5>
                    <p class="card-text"><?php echo $row["Descripcion"] ?></p>
                    <a href="./info_mascota.php?idMascota=<?php echo $row["ID"] ?>" class="btn btn-primary">Más
                        información</a>
                </div>
            </div>

            <script>
                if ("<?php echo $row["Foto"]; ?>" == "") {
                    document.querySelector("#id<?php echo $row["ID"] ?> img").src = "../media/0.jpg";
                }
            </script>

        <?php } ?>
    </section>

</main>

<?php
// Visualizar mensaje de sesión cerrada con éxito.
if (isset($_GET['session']) && $_GET['session'] == 'logoutok') {
?>
    <script>
        document.querySelector('#logout').classList.replace("d-none", "d-inline");
    </script>
<?php
}
// Visualizar mensaje de acceso denegado.
if (isset($_GET['session']) && $_GET['session'] == 'denegado') {
?>
    <script>
        document.querySelector('#denegado').classList.replace("d-none", "d-inline");
    </script>
<?php
}
FooterHTML();
?>