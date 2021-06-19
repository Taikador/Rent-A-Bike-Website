<?php
session_start();

if (isset($_POST["submit"])) {

    require_once '../db.inc.php';

    $password       = mysqli_real_escape_string($conn, $_POST['password']);
    $id             = mysqli_real_escape_string($conn, $_SESSION['userid']);

    require_once '../functions.inc.php';

    UpdatePassword($conn, $password, $id);

}
else {
    header("location: ../../admin/dash.admin.php");
    exit();
}