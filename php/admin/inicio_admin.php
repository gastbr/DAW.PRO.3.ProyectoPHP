<?php
include '../inc/func.inc.php';
include '../inc/mysql.inc.php';
HeadHTML();
session_start();
if (!$_SESSION['admin']) {
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

    <span class="bajaMascota text-danger fw-bold d-none">Baja realizada con éxito: ID#<?php echo $_GET['bajaMascota']; ?></span>
    <span class="bajaAnfitrion text-danger fw-bold d-none">Baja realizada con éxito: DNI <?php echo $_GET['bajaAnfitrion']; ?></span>

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

                        <!-- Modales mascota -->

                        <div class="modal fade" id="modalMascotaInfo<?php echo $row['ID']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5"><?php echo $row['Nombre']; ?> (ID #<?php echo $row['ID']; ?>)</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img class="img-fluid rounded" src="../../mediabd/<?php echo $row['Foto']; ?>">
                                        <ul class="list-group my-4">
                                            <li class="list-group-item">Raza: <strong><?php echo $row['Raza']; ?></strong></li>
                                            <li class="list-group-item">Tamaño: <strong><?php echo $row['Tamanio']; ?></strong></li>
                                            <li class="list-group-item">Fecha de nacimiento: <strong class="fecha"><?php echo $row['FechaNacimiento']; ?></strong></li>
                                            <li class="list-group-item">Sexo: <strong><?php echo $row['Sexo']; ?></strong></li>
                                            <li class="list-group-item">Localización: <strong><?php echo ucfirst($row['Localizacion']); ?></strong></li>
                                            <li class="list-group-item">DNI anfitrión: <strong><?php if ($rowAnfitrion) {
                                                                                                    echo $rowAnfitrion['Anfitrion'];
                                                                                                } else {
                                                                                                    echo "N/A";
                                                                                                } ?></strong></li>
                                            <li class="list-group-item">Descripción: <strong><?php echo $row['Descripcion']; ?></strong></li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <p>Fecha de registro: <strong><?php echo $row['FechaRegistro']; ?></strong></p>
                                        <button type="button" class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#modalMascotaBaja<?php echo $row['ID']; ?>">Baja</button>
                                        <button type="button" class="btn btn-success mx-1" data-bs-toggle="modal" data-bs-target="#modalMascotaEditar<?php echo $row['ID']; ?>">Editar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalMascotaEditar<?php echo $row['ID']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5"><?php echo $row['Nombre']; ?></h1>
                                        <img class="img-fluid w-25 rounded mx-5" src="./../../mediabd/<?php echo $row['Foto']; ?>" alt="Minuatura de la foto.">
                                        <button type="button" class="btn-close position-absolute m-2 top-0 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="inicio_admin.php?mascota=editar" method="post">
                                            <div class="alta_formInput">
                                                <label for="id">ID: </label>
                                                <input readonly name="id" type="text" value="<?php echo $row['ID']; ?>">
                                            </div>

                                            <div class="alta_formInput">
                                                <label for="nombre">Nombre: <?php echo $row['Nombre']; ?></label>
                                                <input required name="nombre" type="text" placeholder="Nuevo nombre">
                                            </div>

                                            <div class="alta_formInput">
                                                <label for="raza">Raza: <?php echo $row['Raza']; ?></label>
                                                <select required name="raza">
                                                    <option value="" disabled selected>Selecciona nueva raza</option>
                                                    <option value="Pastor Aleman">Pastor Alemán</option>
                                                    <option value="Chihuahua">Chihuahua</option>
                                                    <option value="Bardino">Bardino</option>
                                                    <option value="Labrador">Labrador</option>
                                                    <option value="Pinscher">Pinscher</option>
                                                    <option value="Golden Retriever">Golden Retriever</option>
                                                    <option value="Pastor Belga">Pastor Belga</option>
                                                    <option value="Mestizo">Mestizo</option>
                                                </select>
                                            </div>

                                            <div class="alta_formInput">
                                                <label for="tamanio">Tamaño: <?php echo $row['Tamanio']; ?></label>
                                                <select required name="tamanio">
                                                    <option value="" disabled selected>Selecciona nuevo tamaño</option>
                                                    <option value="pequeño">Pequeño</option>
                                                    <option value="mediano">Mediano</option>
                                                    <option value="grande">Grande</option>
                                                </select>
                                            </div>

                                            <div class="alta_formInput">
                                                <label for="nacimiento">Fecha de nacimiento:</label>
                                                <input required name="nacimiento" type="date" value="<?php echo $row['FechaNacimiento']; ?>">
                                            </div>

                                            <div class="alta_formInput">
                                                <label for="sexo">Sexo: <?php echo $row['Sexo']; ?></label>
                                                <label><input required type="radio" name="sexo" value="hembra"> Hembra</label>
                                                <label><input type="radio" name="sexo" value="macho"> Macho</label>
                                            </div>

                                            <div class="alta_formInput">
                                                <label for="descripcion">Descripción (opcional):</label><br>
                                                <textarea name="descripcion" rows="4" cols="50"><?php echo $row['Descripcion']; ?></textarea>
                                            </div>

                                            <div class="d-flex flex-row-reverse">
                                                <button class="btn btn-success mx-2" type="submit" name="submit">Confirmar edición</button>
                                                <a href="inicio_admin.php" class="btn btn-outline-secondary">Volver</a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <button type="button" class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#modalMascotaBaja<?php echo $row['ID']; ?>">Baja</button>
                                        <p>Fecha de registro: <strong><?php echo $row['FechaRegistro']; ?></strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalMascotaBaja<?php echo $row['ID']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5"><?php echo $row['Nombre'] . '(ID #' . $row['ID'] . ")"; ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Seguro que quieres dar de baja a <strong><?php echo $row['Nombre'] . ' (ID #' . $row['ID'] . ")"; ?></strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <a href="inicio_admin.php?bajaMascota=<?php echo $row['ID']; ?>"><button type="button" class="btn btn-danger">Dar de baja</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>

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

                    <!-- Modales anfitrión -->

                    <div class="modal fade" id="modalAnfitrionInfo<?php echo $row['DNI']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5"><?php echo $row['Nombre'] . " " . $row['Apellido1'] . " " . $row['Apellido2']; ?> (DNI <?php echo $row['DNI']; ?>)</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group my-4">
                                        <li class="list-group-item">Teléfono: <strong><?php echo $row['Telefono']; ?></strong></li>
                                        <li class="list-group-item">Dirección: <strong><?php echo $row['Direccion']; ?></strong></li>
                                        <li class="list-group-item">Disponibilidad: <strong><?php echo $row['Disponibilidad']; ?></strong></li>
                                        <li class="list-group-item">Usuario: <strong><?php echo $row['Usuario']; ?></strong></li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#modalAnfitrionBaja<?php echo $row['DNI']; ?>">Baja</button>
                                    <button type="button" class="btn btn-success mx-1" data-bs-toggle="modal" data-bs-target="#modalAnfitrionEditar<?php echo $row['DNI']; ?>">Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalAnfitrionEditar<?php echo $row['DNI']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5"><?php echo $row['Nombre'] . " " . $row['Apellido1'] . " " . $row['Apellido2']; ?></h1>
                                    <button type="button" class="btn-close position-absolute m-2 top-0 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="inicio_admin.php?anfitrion=editar" method="post">
                                        <h5>Información personal</h5>
                                        <div class="alta_formInput">
                                            <label for="id">DNI: </label>
                                            <input readonly name="dni" type="text" value="<?php echo $row['DNI']; ?>">
                                        </div>

                                        <div class="alta_formInput">
                                            <label for="nombre">Nombre: </label>
                                            <input required readonly name="nombre" type="text" value="<?php echo $row['Nombre']; ?>">
                                        </div>

                                        <div class="alta_formInput">
                                            <label for="nombre">Primer apellido: </label>
                                            <input required readonly name="nombre" type="text" value="<?php echo $row['Apellido1']; ?>">
                                        </div>

                                        <div class="alta_formInput">
                                            <label for="nombre">Segundo apellido: </label>
                                            <input required readonly name="nombre" type="text" value="<?php echo $row['Apellido2']; ?>">
                                        </div>

                                        <div class="alta_formInput">
                                            <label for="tel">Teléfono:</label>
                                            <input required name="tel" type="tel" pattern="^[6789]{1}[0-9]{8}$" value="<?php echo $row['Telefono'] ?>">
                                        </div>

                                        <div class="alta_formInput">
                                            <label for="dir">Dirección:</label>
                                            <input required name="dir" type="text" value="<?php echo $row['Direccion'] ?>">
                                        </div>

                                        <h5>Disponibilidad:</h5><span><?php echo $row['Disponibilidad']; ?></span>
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

                                        <div class="d-flex flex-row-reverse">
                                            <button class="btn btn-success mx-2" type="submit" name="submit">Confirmar edición</button>
                                            <a href="inicio_admin.php" class="btn btn-outline-secondary">Volver</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="button" class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#modalAnfitrionBaja<?php echo $row['DNI']; ?>">Baja</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalAnfitrionBaja<?php echo $row['DNI']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5"><?php echo $row['Nombre'] . " " . $row['Apellido1'] . " " . $row['Apellido2']; ?> (DNI <?php echo $row['DNI']; ?>)</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Seguro que quieres dar de baja a <strong><?php echo $row['Nombre'] . " " . $row['Apellido1'] . " " . $row['Apellido2']; ?> (DNI <?php echo $row['DNI']; ?>)</strong>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <a href="inicio_admin.php?bajaAnfitrion=<?php echo $row['DNI']; ?>"><button type="button" class="btn btn-danger">Dar de baja</button></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fin modal -->
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
// Visualizar mensaje de baja realizada con éxito.
if (isset($_GET['bajaMascota'])) {
?>
    <script>
        document.querySelector('.bajaMascota').classList.replace("d-none", "d-inline");
    </script>
<?php
}
if (isset($_GET['bajaAnfitrion'])) {
?>
    <script>
        document.querySelector('.bajaAnfitrion').classList.replace("d-none", "d-inline");
    </script>
<?php
}
FooterHTML();
?>