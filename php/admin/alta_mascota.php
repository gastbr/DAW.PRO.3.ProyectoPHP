<?php
include '../inc/func.inc.php';
include '../inc/mysql.inc.php';
HeadHTML();
if (isset($_GET["opcion"]) && $_GET["opcion"] == "alta_ok") {
    ?>
    <div class="alert alert-success">Mascota añadida con éxito a la base de datos.</div>
<?php } ?>

<form action="alta_mascota.php?opcion=alta_mascota" method="post" enctype="multipart/form-data">

    <div class="alta_formInput">
        <label for="nombre">Nombre:</label>
        <input name="nombre" type="text">
    </div>

    <div class="alta_formInput">
        <label for="raza">Raza:</label>
        <select name="raza">
            <option value="pAleman">Pastor Alemán</option>
            <option value="chihuahua">Chihuahua</option>
            <option value="bardino">Bardino</option>
            <option value="labrador">Labrador</option>
            <option value="pinscher">Pinscher</option>
            <option value="golden">Golden Retriever</option>
            <option value="pBelga">Pastor Belga</option>
        </select>
    </div>

    <div class="alta_formInput">
        <label for="tamanio">Tamaño:</label>
        <select name="tamanio">
            <option value="peq">Pequeño</option>
            <option value="med">Mediano</option>
            <option value="gr">Grande</option>
        </select>
    </div>

    <div class="alta_formInput">
        <label for="nacimiento">Fecha de nacimiento:</label>
        <input name="nacimiento" type="date">
    </div>

    <div class="alta_formInput">
        <label for="sexo">Sexo:</label>
        <label><input type="radio" name="sexo" value="hembra"> Hembra</label>
        <label><input type="radio" name="sexo" value="macho"> Macho</label>
    </div>

    <div class="alta_formInput">
        <label for="localizacion">Localización:</label>
        <label onclick="document.getElementById('acogida').style.display='none'; document.getElementById('acogida').required = false;"><input type="radio" name="localizacion"
                value="albergue"> Albergue</label>
        <label onclick="document.getElementById('acogida').style.display='inline-block'; document.getElementById('acogida').required = true"><input type="radio"
                name="localizacion" value="acogida"> Acogida</label>
    </div>

    <div id="acogida">
        <div class="alta_formInput">
            <label for="dni_acogida">DNI del anfitrión:</label>
            <input type="text" name="dni_acogida">
        </div>
    </div>

    <div class="alta_formInput">
        <label for="descripcion">Descripción:</label><br>
        <textarea name="descripcion" rows="4" cols="50"></textarea>
    </div>

    <div class="alta_formInput">
        <label for="foto">Foto</label>
        <input type="file" name="foto">
    </div>

    <button type="submit" name="submit">Registrar mascota</button>
</form>

<?php
FooterHTML();
?>