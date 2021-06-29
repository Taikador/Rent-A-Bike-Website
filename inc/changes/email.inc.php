<?php
session_start();

if (isset($_POST["submit"])) {

    require_once '../db.inc.php';

    $email              = mysqli_real_escape_string($conn, $_POST['email']);
    $id                 = mysqli_real_escape_string($conn, $_SESSION['userid']);

    require_once '../functions.inc.php';

    if (invalidEmail($email) !== false) {
        header("location: ../../admin/dash.admin.php?error=novalidemail");
        exit();
    } else if (UsernameExists($conn, $email)) {
        header("location: ../../admin/dash.admin.php?error=novalidemail");
        exit();
    }

    UpdateEmailAdmin($conn, $email, $id);

}
else {
    header("location: ../../admin/dash.admin.php");
    exit();
}