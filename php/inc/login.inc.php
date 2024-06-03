<?php
session_start();

$mysqli = new mysqli("localhost:3307", "root", "", "albergue");
if (!$mysqli) {
    die("No se pudo conectar a la BBDD: " . mysqli_connect_error());
}

#region LOG IN

if (isset($_GET['session'])) {

    if ($_GET['session'] == 'login' && isset($_POST['user']) && isset($_POST['pass'])) {
        $user = addcslashes($_POST['user'], "='\"");
        $pass = md5(addcslashes($_POST['pass'], "='\""));

        $query = "SELECT EXISTS(SELECT username, pass FROM albergue.usuario WHERE username = '$user' and pass = '$pass') as 'check';";
        $table = $mysqli->query($query);
        $checkLogin = $table->fetch_all(MYSQLI_ASSOC)[0]['check'];

        if (!$checkLogin) {
            header("Location: ../login.php?login=fail");
            exit();
        } else if ($checkLogin) {
            $_SESSION['user'] = $user;
            header("Location: ../admin/inicio_admin.php");
        }
    }

    #region LOG OUT

    if ($_GET['session'] == 'logout') {
        session_unset();
        session_destroy();
        header('Location: ../index.php?session=logoutok');
    }
}