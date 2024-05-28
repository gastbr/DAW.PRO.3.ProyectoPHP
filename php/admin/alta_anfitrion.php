<?php
include '../inc/func.inc.php';
include '../inc/mysql.inc.php';
HeadHTML();
if (isset($_GET["opcion"]) && $_GET["opcion"] == "alta_ok") {

    ?>
    <div class="alert alert-success">Anfitrión añadido con éxito a la base de datos.</div>
<?php } ?>

<a href="inicio_admin.php" class="btn btn-outline-secondary mt-2 mx-4">Volver</a>

<form action="alta_anfitrion.php?opcion=alta_anfitrion" method="post">
    <h2>Alta nuevo anfitrión</h2>
    <h5>Información de login</h5>
    <div class="alta_formInput">
        <label for="email">Correo electrónico:</label>
        <input required name="email" type="email">
    </div>

    <div class="alta_formInput">
        <label for="username">Usuario:</label>
        <input required name="username" type="text" pattern="[0-9a-zA-Z?=!#$()_-]{2,15}">
    </div>

    <div class="alta_formInput">
        <label for="pass">Contraseña:</label>
        <input required name="pass" type="password" pattern="[0-9a-zA-Z?=!#$()_-]{2,15}">
    </div>

    <h5>Información personal</h5>

    <div class="alta_formInput">
        <label for="dni">DNI:</label>
        <input required name="dni" type="text" pattern="^[0-9]{8}[A-Za-z]{1}$">
    </div>

    <div class="alta_formInput">
        <label for="nombre">Nombre:</label>
        <input required name="nombre" type="text" pattern="[a-zA-Z]{2,15}">
    </div>

    <div class="alta_formInput">
        <label for="apellido1">Primer apellido:</label>
        <input required name="apellido1" type="text" pattern="[a-zA-Z]{2,15}">
    </div>

    <div class="alta_formInput">
        <label for="apellido2">Segundo apellido:</label>
        <input name="apellido2" type="text" pattern="[a-zA-Z]{2,15}">
    </div>

    <div class="alta_formInput">
        <label for="tel">Teléfono:</label>
        <input required name="tel" type="tel" pattern="^[6789]{1}[0-9]{8}$">
    </div>

    <div class="alta_formInput">
        <label for="dir">Dirección:</label>
        <input required name="dir" type="text">
    </div>

    <h5>Disponibilidad:</h5>
    <div class="alta_formInput">
        <div class="checkboxDisponibilidad">
            <input name="Mañana" type="checkbox" value="on">
            <label for="Mañana">Mañana </label>
        </div>

        <div class="checkboxDisponibilidad">
            <input name="Tarde" type="checkbox" value="on">
            <label for="Tarde">Tarde </label>
        </div>

        <br>
        <span>-------------</span>

        <div class="checkboxDisponibilidad">
            <input name="L" type="checkbox" value="on">
            <label for="L">Lunes </label>
        </div>

        <div class="checkboxDisponibilidad">
            <input name="M" type="checkbox" value="on">
            <label for="M">Martes </label>
        </div>

        <div class="checkboxDisponibilidad">
            <input name="X" type="checkbox" value="on">
            <label for="X">Miércoles </label>
        </div>

        <br>

        <div class="checkboxDisponibilidad">
            <input name="J" type="checkbox" value="on">
            <label for="J">Jueves </label>
        </div>

        <div class="checkboxDisponibilidad">
            <input name="V" type="checkbox" value="on">
            <label for="V">Viernes </label>
        </div>

        <div class="checkboxDisponibilidad">
            <input name="S" type="checkbox" value="on">
            <label for="S">Sábado </label>
        </div>

        <div class="checkboxDisponibilidad">
            <input name="D" type="checkbox" value="on">
            <label for="D">Domingo </label>
        </div>

        <button type="button" class="btn btn-outline-secondary btn-sm d-inline-block my-3" onclick="marcarTodo()">
            Marcar todo</button>
        <button type="button" class="btn btn-outline-secondary btn-sm d-inline-block my-3" onclick="desmarcarTodo()">
            Desmarcar todo</button>

    </div>

    <a href="./inicio_admin.php" class="btn btn-outline-secondary">Volver</a>
    <button class="btn btn-success" type="submit" name="submit">Registrar anfitrión</button>
</form>

<script>

    function marcarTodo() {
        let checkboxes = document.querySelectorAll('.checkboxDisponibilidad>input');
        for (let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = true;
        }
    }

    function desmarcarTodo() {
        let checkboxes = document.querySelectorAll('.checkboxDisponibilidad>input');
        for (let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }
    }

</script>

<?php
FooterHTML();
?>