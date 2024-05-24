<?php
include '../inc/func.inc.php';
include '../inc/mysql.inc.php';
HeadHTML();
if (isset($_GET["opcion"]) && $_GET["opcion"] == "alta_ok") {
?>
    <div class="alert alert-success">Mascota añadida con éxito a la base de datos.</div>
<?php } ?>

<form action="alta_mascota.php?opcion=alta_mascota" method="post" enctype="multipart/form-data">
    <h2>Alta nuevo ingreso</h2>
    <div class="alta_formInput">
        <label for="nombre">Nombre:</label>
        <input required name="nombre" type="text">
    </div>

    <div class="alta_formInput">
        <label for="raza">Raza:</label>
        <select required name="raza">
            <option value="" disabled selected>Selecciona raza</option>
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
        <select required name="tamanio">
            <option value="" disabled selected>Selecciona tamaño</option>
            <option value="peq">Pequeño</option>
            <option value="med">Mediano</option>
            <option value="gr">Grande</option>
        </select>
    </div>

    <div class="alta_formInput">
        <label for="nacimiento">Fecha de nacimiento:</label>
        <input required name="nacimiento" type="date">
    </div>

    <div class="alta_formInput">
        <label for="sexo">Sexo:</label>
        <label><input required type="radio" name="sexo" value="hembra"> Hembra</label>
        <label><input type="radio" name="sexo" value="macho"> Macho</label>
    </div>

    <div class="alta_formInput">
        <label for="localizacion">Localización:</label>
        <label onclick="document.getElementById('acogida').style.display='none'; document.querySelector('#acogida input').required = false;"><input required type="radio" name="localizacion" value="albergue"> Albergue</label>
        <label onclick="document.getElementById('acogida').style.display='inline-block'; document.querySelector('#acogida input').required = true;"><input type="radio" name="localizacion" value="acogida"> Acogida</label>
    </div>

    <div id="acogida">
        <div class="alta_formInput">
            <label for="dni_acogida">DNI del anfitrión:</label>
            <input type="text" name="dni_acogida">
        </div>
    </div>

    <div class="alta_formInput">
        <label for="descripcion">Descripción (opcional):</label><br>
        <textarea name="descripcion" rows="4" cols="50"></textarea>
    </div>

    <div class="alta_formInput">
        <label for="foto">Foto (opcional)</label>
        <input type="file" name="foto">
    </div>

    <a href="inicio_admin.php" class="btn btn-outline-secondary">Volver</a>
    <button class="btn btn-success" type="submit" name="submit">Registrar mascota</button>
</form>

<?php
FooterHTML();
?>