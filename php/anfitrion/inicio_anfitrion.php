<?php
session_start();
$_SESSION['loc'] = "inicio_anfitrion";
include '../inc/func.inc.php';
include '../inc/mysql.inc.php';
HeadHTML();

if (!isset($_SESSION['admin']) || $_SESSION['admin']) {
    header("Location: ../index.php?session=denegado");
    exit();
}

?>
<main class="container mt-2 mx-3">
    <h1 class="my-3">¡Bienvenido <?php echo $user; ?>!</h1>
    <div class="my-4">
        <a href="../index.php" type="button" class="btn btn-outline-success">Ver listado público</a>
        <a href="../inc/login.inc.php?session=logout" type="button" class="btn btn-danger">Cerrar la sesión</a>
    </div>

    <h4>Tus datos personales:</h4>

    <ul class="list-group d-inline-block m-2">
        <li class="list-group-item"><strong>DNI</strong>: <?php echo $rowAnfitrion['DNI']; ?></li>
        <li class="list-group-item"><strong>Nombre</strong>: <?php echo $rowAnfitrion['Nombre'] ?></li>
        <li class="list-group-item"><strong>Primer apellido</strong>: <?php echo $rowAnfitrion['Apellido1'] ?></li>
        <li class="list-group-item"><strong>Segundo apellido</strong>: <?php echo $rowAnfitrion['Apellido2'] ?></li>
        <li class="list-group-item"><strong>Teléfono</strong>: <?php echo $rowAnfitrion['Telefono'] ?></li>
        <li class="list-group-item"><strong>Dirección</strong>: <?php echo $rowAnfitrion['Direccion'] ?></li>
        <li class="list-group-item"><strong>Disponibilidad</strong>: <?php echo $rowAnfitrion['Disponibilidad'] ?></li>
        <li class="list-group-item"><strong>Usuario</strong>: <?php echo $rowAnfitrion['Usuario'] ?></li>
    </ul>

    <?php
    if (isset($tablaMascota) && $tablaMascota->num_rows > 0) {
        while ($row = $tablaMascota->fetch_assoc()) {
            $id = $row['ID'];
            $rowAnfitrion = $tablaAnfitrion->fetch_assoc();
    ?>
            <h4>Tus mascotas en acogida:</h4>
            <table id="tablaMascota" class="table d-block">
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
                    <tr>
                        <th scope="row"><?php echo $row['ID']; ?></th>
                        <td><?php echo $row['Nombre']; ?></td>
                        <td><?php echo $row['Raza']; ?></td>
                        <td class="fecha"><?php echo $row['FechaNacimiento']; ?></td>
                        <td class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalMascotaInfo<?php echo $row['ID']; ?>">Ver ficha completa</button>
                        </td>
                    </tr>

                    <?php anfitrion_ModalesMascota($row, $rowAnfitrion); ?>

                    <script>
                        // Poner la imagen de "imagen no disponible" en las entradas sin foto

                        if ("<?php echo $row["Foto"]; ?>" == "") {
                            document.querySelector("#modalMascotaInfo<?php echo $row['ID']; ?> .img-fluid").src = "../../media/0.jpg";
                            document.querySelector("#modalMascotaEditar<?php echo $row['ID']; ?> .img-fluid").src = "../../media/0.jpg";
                        }
                    </script>
            <?php }
    } ?>

</main>

<?php
FooterHTML();
?>