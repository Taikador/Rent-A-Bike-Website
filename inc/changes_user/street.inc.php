<?php
session_start();

if (isset($_POST["submit"])) {

    require_once '../db.inc.php';

    $street                 = mysqli_real_escape_string($conn, $_POST['street']);
    $id                     = mysqli_real_escape_string($conn, $_SESSION['userid']);

    require_once '../functions.inc.php';

    UpdateStreetUser($conn, $street, $id);

}
else {
    header("location: ../../user/dash.user.php");
    exit();
}