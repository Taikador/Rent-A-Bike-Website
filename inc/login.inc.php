<?php

if (isset($_POST["submit"])) {

    require_once 'db.inc.php';

    $email              = mysqli_real_escape_string($conn, $_POST['email']);
    $password           = mysqli_real_escape_string($conn, $_POST['password']);

    require_once 'functions.inc.php';

    if (emptyInputLogin($email, $password) !== false) {
        header("location: ../index.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $email, $password);

}
else {
    header("location: ../index.php");
    exit();
}