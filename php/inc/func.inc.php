<?php

function HeadHTML()
{
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="./../../media/favicon.png">
        <link rel="icon" href="./../media/favicon.png">
        <title>Albergue Majada Marcial</title>
    </head>

    <body>
    <?php
}

function FooterHTML()
{
    ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}

function ModalesMascota()
{
?>
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

<?php
}

function ModalesAnfitrion()
{
?>
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

<?php
}
?>