<?php

session_start();

$mysqli = new mysqli("localhost:3307", "root", "", "albergue");
if (!$mysqli) {
    die("No se pudo conectar a la BBDD: " . mysqli_connect_error());
}

if (isset($_POST['usua'])

$query = 

$_SESSION[''];