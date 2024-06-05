<?php
include 'inc/func.inc.php';
include 'inc/mysql.inc.php';
HeadHTML();
$infoMascota = $table->fetch_assoc();
?>
<main>
    <a href="./index.php" class="btn btn-success m-2">Volver al listado</a>
    <section class="container">

        <div class="row">
            <h1><?php echo $infoMascota["Nombre"] ?></h1>
        </div>

        <div class="row bg-secondary p-5">
            <div class="col-12 col-lg-4">
                <img class="img-fluid" src="../mediabd/<?php echo $infoMascota["Foto"] ?>"
                    alt="Foto de <?php echo $infoMascota["Nombre"] ?>.">
            </div>

            <div id="info" class="col-12 col-lg-8">
                <h3>Raza: </h3>
                <p class="bg-light p-1 d-inline-block"><?php echo $infoMascota["Raza"]; ?></p>
                <h3>Fecha de nacimiento: </h3>
                <p class="bg-light p-1 d-inline-block"><?php echo $infoMascota["FechaNacimiento"]; ?></p>
                <h3>Sexo: </h3>
                <p class="bg-light p-1 d-inline-block"><?php echo $infoMascota["Sexo"]; ?></p>
                <h3>Localización: </h3>
                <p class="bg-light p-1 d-inline-block"><?php echo ucfirst($infoMascota["Localizacion"]); ?></p>
                <h3>Tamaño: </h3>
                <p class="bg-light p-1 d-inline-block"><?php echo $infoMascota["Tamanio"]; ?></p>
                <h3>Descripción: </h3>
                <p class="bg-light p-1 d-inline-block"><?php echo $infoMascota["Descripcion"]; ?></p>
            </div>
        </div>

    </section>
</main>

<script>
    // Formatear la fecha del estilo de MySQL "yyyy-mm-dd" a "d-m-yyyy". 
    let fecha = document.querySelectorAll("#info p")[1].textContent;
    let date = new Date(fecha);
    fecha = date.toLocaleDateString("es-ES");
    document.querySelectorAll("#info p")[1].textContent = fecha;

    if ("<?php echo $infoMascota["Foto"]; ?>" == "") {
        document.querySelector(".img-fluid").src = "../media/0.jpg";
    }

</script>

<?php
FooterHTML();
?>