<?php
session_start();

if (isset($_POST["submit"])) {

    require_once '../db.inc.php';

    $street                 = mysqli_real_escape_string($conn, $_POST['street']);
    $id                     = mysqli_real_escape_string($conn, $_SESSION['userid']);

    require_once '../functions.inc.php';

    UpdateStreet($conn, $street, $id);

}
else {
    header("location: ../../admin/dash.admin.php");
    exit();
}