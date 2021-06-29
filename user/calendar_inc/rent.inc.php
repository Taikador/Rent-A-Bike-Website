<?php

include_once '../../inc/db.inc.php';
$data = array();

if ($_POST['file_id'] == 0) {
    $statementTarif = $conn->query("SELECT name FROM tariff");
    $resultTarif = $statementTarif->fetch_all(MYSQLI_ASSOC);
    foreach ($resultTarif as $row) {
        $data[] = array(
            'name' => $row['name']
        );
    }
} else if ($_POST['file_id'] == 1) {
    $statement = $conn->query("SELECT name FROM class");
    $result = $statement->fetch_all(MYSQLI_ASSOC);

    foreach ($result as $row) {
        $data[] = array(
            'art'   => $row["name"]
        );
    }
}




echo json_encode($data);
