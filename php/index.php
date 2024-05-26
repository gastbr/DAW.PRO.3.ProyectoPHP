<?php
include 'inc/func.inc.php';
include 'inc/mysql.inc.php';
HeadHTML();
?>
<main>
    <a href="./admin/inicio_admin.php" class="btn btn-success m-2">Admin login</a>
    <section class="container">

        <!-- <?php for ($i = 0; $i < 20; $i++) { ?>
            <div class="card">
                <img src="../media/perro1.jpg" alt="Imagen del perro 1" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Ambrosio</h5>
                    <p class="card-text">Descripción del bueno de ambrosio.</p>
                    <a href="#" class="btn btn-primary">Visitar</a>
                </div>
            </div>
        <?php } ?>
         -->


        <div class="card">
            <img src="../media/perro1.jpg" alt="Imagen del perro 1" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title">Ambrosio</h5>
                <p class="card-text">Descripción del bueno de ambrosio.</p>
                <a href="#" class="btn btn-primary">Visitar</a>
            </div>
        </div>


    </section>
</main>

<?php
FooterHTML();
?>