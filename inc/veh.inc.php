<?php

if (isset($_POST["submit"])) {

    require_once 'db.inc.php';

    $chassis_number     = mysqli_real_escape_string($conn, $_POST['chassis_number']);
    $class              = mysqli_real_escape_string($conn, $_POST['class']);
    $station            = mysqli_real_escape_string($conn, $_POST['station']);

    require_once 'functions.inc.php';

    createVehicle($conn, $chassis_number, $class, $station);

}
else {
    header("location: ../admin/veh.admin.php");
    exit();
}