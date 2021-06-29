<?php
session_start();

if (isset($_POST["submit"])) {

    require_once '../db.inc.php';

    $email              = mysqli_real_escape_string($conn, $_POST['email']);
    $id                 = mysqli_real_escape_string($conn, $_SESSION['userid']);

    require_once '../functions.inc.php';

    if (invalidEmail($email) !== false) {
        header("location: ../../user/dash.user.php?error=novalidemail");
        exit();
    } else if (UsernameExists($conn, $email)) {
        header("location: ../../user/dash.user.php?error=novalidemail");
        exit();
    }

    UpdateEmailUser($conn, $email, $id);

}
else {
    header("location: ../../user/dash.user.php");
    exit();
}