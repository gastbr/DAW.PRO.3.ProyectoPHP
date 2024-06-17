<?php
include 'inc/func.inc.php';
include 'inc/mysql.inc.php';
HeadHTML();
$query = "SELECT * FROM albergue.mascota;";

if (isset($_GET['filtro'])) {
    if ($_GET['filtro'] == 'albergue') {
        $query = "SELECT * FROM albergue.mascota WHERE localizacion = 'albergue';";
    }
    if ($_GET['filtro'] == 'acogida') {
        $query = "SELECT * FROM albergue.mascota WHERE localizacion = 'acogida';";
    }
    if ($_GET['filtro'] == 'nombreasc') {
        $query = "SELECT * FROM albergue.mascota ORDER BY nombre ASC;";
    }
    if ($_GET['filtro'] == 'nombredesc') {
        $query = "SELECT * FROM albergue.mascota ORDER BY nombre DESC;";
    }
}

$table = $mysqli->query($query);
?>
<main>
    <a href="login.php" class="btn btn-success mt-2 mx-4">Login</a>
    <span id="logout" class="text-danger fw-bold d-none">La sesión se ha cerrado con éxito.</span>
    <span id="denegado" class="text-danger fw-bold d-none">Acceso denegado.</span>

    <section class="container">

        <div class="d-flex justify-content-around">
            <h6>Filtros:</h6>
            <a class="btn btn-sm btn-outline-primary" href="index.php?filtro=albergue">Ver sólo las mascotas en el albergue.</a>
            <a class="btn btn-sm btn-outline-primary" href="index.php?filtro=acogida">Ver sólo las mascotas en acogida.</a>
            <a class="btn btn-sm btn-outline-primary" href="index.php?filtro=nombreasc">Nombre &uarr;</a>
            <a class="btn btn-sm btn-outline-primary" href="index.php?filtro=nombredesc">Nombre &darr;</a>
        </div>



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