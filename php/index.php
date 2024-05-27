<?php
include 'inc/func.inc.php';
include 'inc/mysql.inc.php';
HeadHTML();
?>
<main>
    <a href="./admin/inicio_admin.php" class="btn btn-success mt-2 mx-4">Admin login</a>

    <section class="container">
        
        <?php while ($row = $table->fetch_assoc()) { ?>
            <div id="id<?php echo $row["ID"] ?>" class="card d-inline-block m-3 align-top">
                <img src="../mediabd/<?php echo $row["Foto"] ?>" alt="Imagen del perro <?php echo $row["ID"] ?>"
                    class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row["Nombre"] ?></h5>
                    <p class="card-text"><?php echo $row["Descripcion"] ?></p>
                    <a href="./info_mascota.php?idMascota=<?php echo $row["ID"] ?>" class="btn btn-primary">Más
                        información</a>
                </div>
            </div>

            <script>
                if ("<?php echo $row["Foto"]; ?>" == "") {
                    document.querySelector("#id<?php echo $row["ID"] ?> img").src = "../media/0.gif";
                }
            </script>

        <?php } ?>
    </section>

</main>

<?php
FooterHTML();
?>