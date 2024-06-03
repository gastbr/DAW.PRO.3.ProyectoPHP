<?php
include '../inc/func.inc.php';
include '../inc/mysql.inc.php';
HeadHTML();
session_start();
?>
<main class="container mt-2 mx-3">
    <h1 class="my-3">¡Bienvenido <?php echo $_SESSION['user']; ?>!</h1>
    <div class="my-4">
        <a href="../index.php" type="button" class="btn btn-outline-success">Ver lsitado público</a>
        <a href="alta_anfitrion.php" type="button" class="btn btn-success">Alta de anfitriones</a>
        <a href="alta_mascota.php" type="button" class="btn btn-success">Alta de mascotas</a>
        <a href="../inc/login.inc.php?session=logout" type="button" class="btn btn-danger">Cerrar la sesión</a>
    </div>

    <div class="d-block">
        <form action="inicio_admin.php?busca=mascota" method="post">
            <input type="text" name="buscar" placeholder="Firulais"><button class="mx-3" type="submit">Buscar
                mascota</button>
            <span class="d-block mt-2">Introducir nombre o ID de mascota.<br>Dejar vacío para ver todos los
                registros.</span>
        </form>
        <form action="inicio_admin.php?busca=anfitrion" method="post">
            <input type="text" name="buscar" placeholder="12345678E"><button class="mx-3" type="submit">Buscar
                anfitrión</button>
            <span class="d-block mt-2">Introducir nombre o DNI de anfitrión.<br>Dejar vacío para ver todos los
                registros.</span>
        </form>
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
            if (isset($_GET['busca']) && $_GET['busca'] == 'mascota' && $table->num_rows > 0) {
                while ($row = $table->fetch_assoc()) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $row['ID']; ?></th>
                        <td><?php echo $row['Nombre']; ?></td>
                        <td><?php echo $row['Raza']; ?></td>
                        <td class="fecha"><?php echo $row['FechaNacimiento']; ?></td>
                        <td class="d-flex justify-content-end">
                            <a href="./info_mascota_admin.php?id=<?php echo $row['ID']; ?>"><button type="button"
                                    class="btn btn-primary btn-sm mx-1">Ver ficha completa</button></a>
                            <a href="./info_mascota_admin.php?opcion=editar&id=<?php echo $row['ID']; ?>"><button type="button"
                                    class="btn btn-success btn-sm mx-1">Editar</button></a>
                            <a href="./confirmar_baja.php?tipo=mascota&id=<?php echo $row['ID']; ?>"><button type="button"
                                    class="btn btn-danger btn-sm mx-1">Baja</button></a>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <td colspan="5"><a href="inicio_admin.php"><button
                            class="my-2 w-100 btn btn-sm btn-outline-secondary">Limpiar tabla</button></a></td>
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
                            <a href="./info_anfitrion_admin.php?id=<?php echo $row['DNI']; ?>"><button type="button"
                                    class="btn btn-primary btn-sm mx-1">Ver ficha completa</button></a>
                            <a href="./info_anfitrion_admin.php?opcion=editar&id=<?php echo $row['DNI']; ?>"><button
                                    type="button" class="btn btn-success btn-sm mx-1">Editar</button></a>
                            <a href="./confirmar_baja.php?tipo=anfitrion&id=<?php echo $row['DNI']; ?>"><button type="button"
                                    class="btn btn-danger btn-sm mx-1">Baja</button></a>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

            <tr>
                <td colspan="5"><a href="inicio_admin.php"><button
                            class="my-2 w-100 btn btn-sm btn-outline-secondary">Limpiar tabla</button></a></td>
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
FooterHTML();
?>