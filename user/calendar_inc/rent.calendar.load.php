<?php

session_start();

include_once '../../inc/db.inc.php';
include_once '../../inc/functions.inc.php';

$data = array();
$id = $_SESSION['userid'];
$id = (int)$id;

$query = "SELECT * FROM `rent-list` WHERE ID_Customer = '$id'";
$statement = $conn->query($query);
$result = $statement->fetch_all(MYSQLI_ASSOC);

foreach ($result as $row) {
    $data[] = array(
        'title'   => "Ausleihe Nr.: " . $row["ID_Rent"],
        'id'   => $row["ID_Rent"],
        'start'   => $row["start"],
        'end'   => $row["end"],
        'tarif'   => getTarif($conn, $row["ID_Tariff"])['name'],
        'klasse'   => getClass($conn, $row["ID_Class"])['name'],
        'kunde_id' => $row['ID_Customer'],
        'price' => $row['price'],
    );
}

echo json_encode($data);
