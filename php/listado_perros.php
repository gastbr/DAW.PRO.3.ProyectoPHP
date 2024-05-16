<?php
include 'inc/func.inc.php';
HeadHTML();
?>
<main>
    <section>

        <p>
            <a href="./admin/alta_mascota.php">Añadir perro</a>
        </p>

        <?php for ($i = 0; $i < 20; $i++) { ?>
            <div class="card">
                <img src="../media/perro1.jpg" alt="Imagen del perro 1" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Ambrosio</h5>
                    <p class="card-text">Descripción del bueno de ambrosio.</p>
                    <a href="#" class="btn btn-primary">Visitar</a>
                </div>
            </div>
        <?php } ?>

    </section>
</main>

<?php
FooterHTML();
?>