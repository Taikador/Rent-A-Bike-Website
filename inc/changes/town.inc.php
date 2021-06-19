<?php
session_start();

if (isset($_POST["submit"])) {

    require_once '../db.inc.php';

    $town               = mysqli_real_escape_string($conn, $_POST['town']);
    $id                 = mysqli_real_escape_string($conn, $_SESSION['userid']);

    require_once '../functions.inc.php';

    UpdateTown($conn, $town, $id);

}
else {
    header("location: ../../admin/dash.admin.php");
    exit();
}