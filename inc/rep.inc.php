<?php

if (isset($_POST["submit"])) {

    require_once 'db.inc.php';

    $date              = mysqli_real_escape_string($conn, $_POST['date']);
    $desc           = mysqli_real_escape_string($conn, $_POST['desc']);
    $vehicle           = mysqli_real_escape_string($conn, $_POST['vehicle']);

    require_once 'functions.inc.php';

    createRepair($conn, $date, $desc, $vehicle);

}
else {
    header("location: ../admin/rep.admin.php");
    exit();
}