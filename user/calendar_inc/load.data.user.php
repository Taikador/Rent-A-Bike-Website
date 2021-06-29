<?php

include_once '../../inc/db.inc.php';

$data = array();

$statement = $conn->query("SELECT name FROM tariff");

$stmt       = $conn->query("SELECT name FROM class");

$result = $statement->fetch_all(MYSQLI_ASSOC);
$resultclass = $stmt->fetch_all(MYSQLI_ASSOC);

foreach ($resultclass as $row) {
    $data[] = array(
        'name' => $row["name"]
    );
}

foreach ($result as $row) {
    $data[] = array(
        'name'   => $row["name"]
    );
}
echo json_encode($data);
