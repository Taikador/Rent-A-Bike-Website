<?php
session_start();

if (isset($_POST["submit"])) {

    require_once '../db.inc.php';

    $firstname      = mysqli_real_escape_string($conn, $_POST['firstname']);
    $id             = mysqli_real_escape_string($conn, $_SESSION['userid']);

    require_once '../functions.inc.php';

    UpdateFirstnameAdmin($conn, $firstname, $id);

}
else {
    header("location: ../../admin/dash.admin.php");
    exit();
}