<?php
include '../inc/func.inc.php';
include '../inc/mysql.inc.php';
HeadHTML();
session_start();
if ($_SESSION['admin']) {
    header("Location: ../index.php?session=denegado");
    exit();
}
?>
<main class="container mt-2 mx-3">
    <h1 class="my-3">¡Bienvenido <?php echo $_SESSION['user']; ?>!</h1>
    <div class="my-4">
        <a href="../index.php" type="button" class="btn btn-outline-success">Ver lsitado público</a>
        <a href="alta_anfitrion.php" type="button" class="btn btn-success">Alta de anfitriones</a>
        <a href="alta_mascota.php" type="button" class="btn btn-success">Alta de mascotas</a>
        <a href="../inc/login.inc.php?session=logout" type="button" class="btn btn-danger">Cerrar la sesión</a>
    </div>

    <span id="bajaMascota" class="text-danger fw-bold d-none">Baja realizada con éxito: ID#<?php echo $_GET['bajaMascota']; ?></span>
    <span id="bajaAnfitrion" class="text-danger fw-bold d-none">Baja realizada con éxito: DNI <?php echo $_GET['bajaAnfitrion']; ?></span>
    <span id="modMascota" class="text-danger fw-bold d-none">Mascota modificada con éxito: ID# <?php echo $_GET['modMascota']; ?></span>

    <div class="d-block">
        <form class="formulario" action="inicio_admin.php?busca=mascota" method="post">
            <h4>Mascotas</h4>
            <input type="text" name="buscar" placeholder="Firulais"><button class="mx-3" type="submit">Buscar
                mascota</button>
        </form>

        <form class="formulario" action="inicio_admin.php?busca=anfitrion" method="post">
            <h4>Anfitriones</h4>
            <input type="text" name="buscar" placeholder="12345678E"><button class="mx-3" type="submit">Buscar
                anfitrión</button>
        </form>
        <span class="d-block mb-5">Introducir nombre, DNI o ID.<br>Dejar <strong>vacío</strong> para ver todos los registros.</span>

    </div>

    <table id="tablaMascota" class="table d-none">
        <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Raza</th>
                <th scope="col">Fecha de nacimiento</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <?php
            if (isset($_GET['busca']) && $_GET['busca'] == 'mascota') {

                if ($table->num_rows > 0) {
                    while ($row = $table->fetch_assoc()) {
                        $id = $row['ID'];
                        $query = "SELECT * FROM albergue.anfitrion_acoge_mascota WHERE Mascota = $id;";
                        $tableAnfitrion = $mysqli->query($query);
                        $rowAnfitrion = $tableAnfitrion->fetch_assoc();
            ?>
                        <tr>
                            <th scope="row"><?php echo $row['ID']; ?></th>
                            <td><?php echo $row['Nombre']; ?></td>
                            <td><?php echo $row['Raza']; ?></td>
                            <td class="fecha"><?php echo $row['FechaNacimiento']; ?></td>
                            <td class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalMascotaInfo<?php echo $row['ID']; ?>">Ver ficha completa</button>
                                <button type="button" class="btn btn-success btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalMascotaEditar<?php echo $row['ID']; ?>">Editar</button>
                                <button type="button" class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalMascotaBaja<?php echo $row['ID']; ?>">Baja</button>
                            </td>
                        </tr>

                        <?php admin_ModalesMascota(); ?>

                        <script>
                            // Poner la imagen de "imagen no disponible" en las entradas sin foto

                            if ("<?php echo $row["Foto"]; ?>" == "") {
                                document.querySelector("#modalMascotaInfo<?php echo $row['ID']; ?> .img-fluid").src = "../../media/0.jpg";
                                document.querySelector("#modalMascotaEditar<?php echo $row['ID']; ?> .img-fluid").src = "../../media/0.jpg";
                            }
                        </script>

                        <!-- Fin modal -->
            <?php
                    }
                }
            }
            ?>
            <tr>
                <td colspan="5"><a href="inicio_admin.php"><button class="my-2 w-100 btn btn-sm btn-outline-secondary">Limpiar tabla</button></a></td>
            </tr>
        </tbody>
    </table>

    <table id="tablaAnfitrion" class="table d-none">
        <thead>
            <tr>
                <th scope="col">DNI</th>
                <th scope="col">Nombre completo</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Username</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <?php

            if (isset($_GET['busca']) && $_GET['busca'] == 'anfitrion' && $table->num_rows > 0) {
                while ($row = $table->fetch_assoc()) {
            ?>
                    <tr>
                        <th scope="row"><?php echo $row['DNI']; ?></th>
                        <td><?php echo $row['Nombre'] . " " . $row['Apellido1'] . " " . $row['Apellido2']; ?></td>
                        <td><?php echo $row['Telefono']; ?></td>
                        <td><?php echo $row['Usuario']; ?></td>
                        <td class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalAnfitrionInfo<?php echo $row['DNI']; ?>">Ver ficha completa</button>
                            <button type="button" class="btn btn-success btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalAnfitrionEditar<?php echo $row['DNI']; ?>">Editar</button>
                            <button type="button" class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalAnfitrionBaja<?php echo $row['DNI']; ?>">Baja</button>
                        </td>
                    </tr>

                    <?php admin_ModalesAnfitrion(); ?>

            <?php
                }
            }
            ?>

            <tr>
                <td colspan="5"><a href="inicio_admin.php"><button class="my-2 w-100 btn btn-sm btn-outline-secondary">Limpiar tabla</button></a></td>
            </tr>

        </tbody>
    </table>

</main>

<script>
    // Formatear las fechas del estilo de MySQL "yyyy-mm-dd" a "d-m-yyyy". 

    let fechas = document.querySelectorAll('.fecha');
    for (let i = 0; i < fechas.length; i++) {
        let date = new Date(fechas[i].textContent);
        fechas[i].textContent = date.toLocaleDateString("es-ES");
    }

    // Muestra las tablas de mascotas o anfitrión según sea necesario
    <?php if (isset($_GET['busca'])) {
        if ($_GET['busca'] == 'mascota') { ?>
            document.getElementById('tablaMascota').classList.replace("d-none", "d-block");
        <?php } else if ($_GET['busca'] == 'anfitrion') {
        ?>
            document.getElementById('tablaAnfitrion').classList.replace("d-none", "d-block");
    <?php
        }
    } ?>
</script>

<?php
// Visualizar mensajes de modificaciones.
if (isset($_GET['bajaMascota'])) {
?>
    <script>
        document.querySelector('#bajaMascota').classList.replace("d-none", "d-inline");
    </script>
<?php
}
if (isset($_GET['bajaAnfitrion'])) {
?>
    <script>
        document.querySelector('#bajaAnfitrion').classList.replace("d-none", "d-inline");
    </script>
<?php
}
if (isset($_GET['modMascota'])) {
?>
    <script>
        document.querySelector('#modMascota').classList.replace("d-none", "d-inline");
    </script>
<?php
}
FooterHTML();
?>