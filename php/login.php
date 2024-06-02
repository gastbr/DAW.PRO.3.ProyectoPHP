<?php
session_start();
include 'inc/func.inc.php';
include 'inc/mysql.inc.php';
HeadHTML();
$infoMascota = $table->fetch_assoc();

if (isset($_SESSION['user'])) {
    header("Location: admin/inicio_admin.php");
    exit();
}
?>

<main class="d-flex justify-content-center">
    <a class="volver d-inline mt-3" href="./index.php">&lt; Volver</a>

    <section class="py-5">

        <div id="login" class="d-inline-block">
            <h2 class="d-block">Login de usuarios</h2>
            <form action="./inc/login.inc.php?session=login" method="post">
                <div class="user my-3 text-left">
                    <label for="user">Usuario:</label>
                    <input class="w-100" type="text" name="user" required>
                </div>
                <div class="pass my-3">
                    <label for="pass">Contraseña:</label>
                    <input class="w-100" type="password" name="pass" required>
                </div>
                <button class="btn btn-success btn-sm w-100" type="submit">Acceder</button>
            </form>
        </div>
        <div class="alert alert-danger my-2 d-none">Usuario o contraseña incorrectos.</div>

    </section>
</main>

<?php
if (isset($_GET['login']) && $_GET['login'] == 'fail') {
?>
    <script>
        document.querySelector(".alert").classList.replace("d-none", "d-block");
    </script>
<?php
}
FooterHTML();
?>