<?php
include '../inc/func.inc.php';
include '../inc/mysql.inc.php';
HeadHTML();
if (isset($_GET["opcion"]) && $_GET["opcion"] == "alta_ok") {
?>
    <div class="alert alert-success">Anfitrión añadido con éxito a la base de datos.</div>
<?php } ?>

<form action="alta_anfitrion.php?opcion=alta_anfitrion" method="post">
    <h2>Alta nuevo anfitrión</h2>
    <h5>Información de login</h5>
    <div class="alta_formInput">
        <label for="email">Correo electrónico:</label>
        <input required name="email" type="email">
    </div>

    <div class="alta_formInput">
        <label for="username">Usuario:</label>
        <input required name="username" type="text" pattern="[0-9a-zA-Z?=!#-_$()]{15}">
    </div>

    <div class="alta_formInput">
        <label for="pass">Contraseña:</label>
        <input required name="pass" type="password" pattern="[0-9a-zA-Z?=!#-_$()]{15}">
    </div>

    <h5>Información personal</h5>

    <div class="alta_formInput">
        <label for="dni">DNI:</label>
        <input required name="dni" type="text" pattern="^[0-9]{8}[A-Za-z]{1}">
    </div>

    <div class="alta_formInput">
        <label for="nombre">Nombre:</label>
        <input required name="nombre" type="text" pattern="[a-zA-Z]{15}">
    </div>

    <div class="alta_formInput">
        <label for="apellido1">Primer apellido:</label>
        <input required name="apellido1" type="text" pattern="[a-zA-Z]{15}">
    </div>

    <div class="alta_formInput">
        <label for="apellido2">Segundo apellido:</label>
        <input name="apellido2" type="text" pattern="[a-zA-Z]{15}">
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
        <div class="checkbox">
            <input name="disponibilidad" type="checkbox" value="Mañana">
            <label for="disponibilidad">Mañana </label>
        </div>

        <div class="checkbox">
            <input name="disponibilidad" type="checkbox" value="Tarde">
            <label for="disponibilidad">Tarde </label>
        </div>

        <br>
        <br>

        <div class="checkbox">
            <input name="disponibilidad" type="checkbox" value="L">
            <label for="disponibilidad">Lunes </label>
        </div>

        <div class="checkbox">
            <input name="disponibilidad" type="checkbox" value="M">
            <label for="disponibilidad">Martes </label>
        </div>

        <div class="checkbox">
            <input name="disponibilidad" type="checkbox" value="X">
            <label for="disponibilidad">Miércoles </label>
        </div>

        <br>

        <div class="checkbox">
            <input name="disponibilidad" type="checkbox" value="J">
            <label for="disponibilidad">Jueves </label>
        </div>

        <div class="checkbox">
            <input name="disponibilidad" type="checkbox" value="V">
            <label for="disponibilidad">Viernes </label>
        </div>

        <div class="checkbox">
            <input name="disponibilidad" type="checkbox" value="S">
            <label for="disponibilidad">Sábado </label>
        </div>

        <div class="checkbox">
            <input name="disponibilidad" type="checkbox" value="D">
            <label for="disponibilidad">Domingo </label>
        </div>

        <button type="button" class="btn btn-outline-secondary btn-sm d-inline-block my-3" onclick="marcarTodo()"> Marcar todo</button>
        <button type="button" class="btn btn-outline-secondary btn-sm d-inline-block my-3" onclick="desmarcarTodo()"> Desmarcar todo</button>

    </div>

    <a href="./inicio_admin.php" class="btn btn-outline-secondary">Volver</a>
    <button class="btn btn-success" type="submit" name="submit">Registrar anfitrión</button>
</form>

<script>
    function marcarTodo() {
        let checkboxes = document.querySelectorAll('.checkbox>input');
        for (let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = true;
        }
    }

    function desmarcarTodo() {
        let checkboxes = document.querySelectorAll('.checkbox>input');
        for (let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }
    }
</script>

<?php
FooterHTML();
?>