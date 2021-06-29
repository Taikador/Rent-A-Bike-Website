<?php
session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';

$className = $_POST['class'];
$tarifName = $_POST['tarif'];
$customerId = $_SESSION['userid'];
$start = $_POST['start'];
$start = date("Y-m-d H:i:s", strtotime($start));

$startPlaceHolder = new DateTime($start);

if (strcasecmp($tarifName, "tag") == 0) {
    $end = $startPlaceHolder->add(new DateInterval('P0Y0M1DT0H0M0S'));
} elseif (strcasecmp($tarifName, "wochenende") == 0) {
    $end = $startPlaceHolder->add(new DateInterval('P0Y0M3DT0H0M0S'));
} elseif (strcasecmp($tarifName, "woche") == 0) {
    $end = $startPlaceHolder->add(new DateInterval('P0Y0M7DT0H0M0S'));
} elseif (strcasecmp($tarifName, "monat") == 0) {
    $end = $startPlaceHolder->add(new DateInterval('P0Y1M0DT0H0M0S'));
} elseif (strcasecmp($tarifName, "jahr") == 0) {
    $end = $startPlaceHolder->add(new DateInterval('P1Y0M0DT0H0M0S'));
} elseif (strcasecmp($tarifName, "leasing") == 0) {
    $end = $startPlaceHolder->add(new DateInterval('P3Y0M0DT0H0M0S'));
}


$end = $end->format("Y-m-d H:i:s");

$class = getClassFromName($conn, $className);
$classPrice = $class['price'];

$tarif = getTarifFromName($conn, $tarifName);
$tarifPrice = $tarif['price'];

$classId = $class['ID_Class'];
$tarifId = $tarif['ID_Tariff'];

$chassisNumber = getVehicleFromClassID($conn, $classId)[0];

$price = $classPrice + $tarifPrice;

createRent($conn, $start, $end, $price, $customerId,$tarifId,$classId,$chassisNumber);

?>
