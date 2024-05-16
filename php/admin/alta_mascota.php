<?php
include '../inc/func.inc.php';
HeadHTML();
?>

<form action="alta_mascota.php" method="post">

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
        <label><input type="radio" name="localizacion" value="albergue">Albergue</label>
        <label onclick="document.getElementById('direc').style.display='block'"><input type="radio" name="localizacion" value="acogida">Acogida</label>
    </div>
    <span id="direc" style="display:none">daksjdlkasjdlkajslkdajs</span>

    <div class="alta_formInput">
        <label for="descripcion">Descripción:</label><br>
        <textarea name="descripcion" rows="4" cols="30"></textarea>
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