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
    $chassisNumber = $row['chassis_number'];
    $queryVehicle = "SELECT ID_Station FROM vehicle WHERE chassis_number = '$chassisNumber'";
    $statementVehicle = $conn->query($queryVehicle);
    $resultVehicle = $statementVehicle->fetch_all(MYSQLI_ASSOC);

    // var_dump($resultVehicle);

    foreach($resultVehicle as $rowVehicle) {
        $stationId = $rowVehicle['ID_Station'];
        $queryStation = "SELECT `rent-station`.street, town.town FROM `rent-station` INNER JOIN town ON town.ZIP = `rent-station`.ZIP WHERE ID_Station = '$stationId'";
        $statementStation = $conn->query($queryStation);
        $dataStation = $statementStation->fetch_all();
        // var_dump($dataStation);

        foreach($dataStation as $rowStation){
            
            // var_dump($rowStation);
            $data[] = array(
                'title'   => "Ausleihe Nr.: " . $row["ID_Rent"],
                'id'   => $row["ID_Rent"],
                'start'   => $row["start"],
                'end'   => $row["end"],
                'tarif'   => getTarif($conn, $row["ID_Tariff"])['name'],
                'klasse'   => getClass($conn, $row["ID_Class"])['name'],
                'station' => $rowStation['0'] .", " .$rowStation['1'],
                'price' => $row['price'],
            );
        }
    }

}

echo json_encode($data);
