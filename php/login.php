<?php
include 'inc/func.inc.php';
include 'inc/mysql.inc.php';
HeadHTML();
$infoMascota = $table->fetch_assoc();
?>

<main>
    <section class="d-flex justify-content-center py-5">
        
        <div id="login" class="d-inline-block">
            <h2 class="d-block" >Login de usuarios</h2>
            <form action="./inc/login.inc.php" method="post">
                <div class="user my-3 text-left">
                    <label for="user">Usuario:</label>
                    <input type="text" name="user">
                </div>
                <div class="pass my-3">
                    <label for="pass">Contraseña:</label>
                    <input type="text" name="pass">
                </div>
                <a class="d-inline" href="./index.php"><button class="btn btn-outline-danger btn-sm d-inline" type="button">Volver</button></a>
                <button class="btn btn-outline-success btn-sm d-inline" type="submit">Acceder</button>
            </form>
        </div>

    </section>
</main>

<?php
FooterHTML();
?>