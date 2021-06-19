<?php
session_start();

if (isset($_POST["submit"])) {

    require_once '../db.inc.php';

    $lastname       = mysqli_real_escape_string($conn, $_POST['lastname']);
    $id             = mysqli_real_escape_string($conn, $_SESSION['userid']);

    require_once '../functions.inc.php';

    UpdateLastname($conn, $lastname, $id);

}
else {
    header("location: ../../admin/dash.admin.php");
    exit();
}