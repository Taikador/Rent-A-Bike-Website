<?php
session_start();

if (isset($_POST["submit"])) {

    require_once '../db.inc.php';

    $phone                  = mysqli_real_escape_string($conn, $_POST['phone']);
    $id                     = mysqli_real_escape_string($conn, $_SESSION['userid']);

    require_once '../functions.inc.php';

    UpdatePhoneUser($conn, $phone, $id);

}
else {
    header("location: ../../user/dash.user.php");
    exit();
}