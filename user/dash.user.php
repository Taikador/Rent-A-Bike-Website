<?php
session_start();
require_once '../inc/db.inc.php';
require_once '../inc/functions.inc.php';

if (isset($_SESSION)) {
    if (!isUser($conn, $_SESSION['userid']) and !isAdmin($conn, $_SESSION['userid'])) {
        header("location: ../error/error_403_page.php");
    }
} else {
    header("location: ../error/error_403_page.php");
}

?>

<script>
        function toggleMenu() {
            let toggle      = document.querySelector('.toggle');
            let navigation  = document.querySelector('.navigation');
            let main        = document.querySelector('.primary');
            toggle.classList.toggle('active');
            navigation.classList.toggle('active');
            main.classList.toggle('active');
        }
</script>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user.css">
    <script src="https://kit.fontawesome.com/2deba413ff.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/svg+xml" href="../img/admin-dash.svg">
    <title>User Dashboard</title>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="../index.php">
                        <span class="icon"><i class="fa fa-bicycle" aria-hidden="true"></i></span>
                        <span class="title"><h2>Parzentny</h2></span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fa fa-home" aria-hidden="true"></i></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="rents.user.php">
                        <span class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        <span class="title">Buchungen</span>
                    </a>
                </li>
                <li>
                    <a href="rent.user.php">
                        <span class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        <span class="title">Jetzt Buchen</span>
                    </a>
                </li>
                <li>
                    <a href="sett.user.php">
                        <span class="icon"><i class="fa fa-key" aria-hidden="true"></i></span>
                        <span class="title">Daten</span>
                    </a>
                </li>
                <li>
                    <a href="../inc/logout.inc.php">
                        <span class="icon"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
                        <span class="title">Ausloggen</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="primary">
            <div class="topbar">
                <div class="toggle" onclick="toggleMenu();"></div>
            </div>

            <div class="cardBoxUser">
                <div class="card">
                    <div>
                        <div class="numbers"><?php include_once '../inc/db.inc.php'; $sql = "SELECT * FROM vehicle"; $statement = $conn->prepare($sql); $statement->execute(); $result=$statement->get_result(); $count=$result->num_rows; echo $count; ?></div>
                        <div class="cardName">Anzahl der Fahrzeuge</div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-biking"></i>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers"><?php include_once '../inc/db.inc.php'; $ID = $_SESSION['userid']; $sql = "SELECT * FROM `rent-list` WHERE ID_Customer LIKE $ID"; $statement = $conn->prepare($sql); $statement->execute(); $result=$statement->get_result(); $count=$result->num_rows; echo $count; ?></div>
                        <div class="cardName">Anzahl der Vermietungen</div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>

            <div class="detailsUser">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Deine Buchungen</h2>
                        <a href="rents.user.php" class="btn">Alle ansehen</a>
                    </div>
                    <?php
                        include_once '../inc/db.inc.php';
                        include_once '../inc/functions.inc.php';

                        $id = $_SESSION['userid'];
                        $uid= (int)$id;

                        $sql = "SELECT 
                                `rent-list`.`start`, `rent-list`.`end`, class.name, tariff.name, `rent-list`.`price`
                                FROM 
                                `rent-list`
                                INNER JOIN 
                                customer ON `rent-list`.`ID_Customer` = customer.ID_Customer 
                                INNER JOIN 
                                class ON `rent-list`.`ID_Class` = class.ID_Class
                                INNER JOIN 
                                tariff ON `rent-list`.`ID_Tariff` = tariff.ID_Tariff
                                WHERE
                                `rent-list`.`ID_Customer` = '$uid'";
                        
                        $dbquery    = $conn->prepare($sql);
                        $dbquery    ->execute();
                        $result     = $dbquery->get_result();
                        $data       = $result->fetch_all();

                        echo "<table class='qtable' id='booking-table'>";
                        echo "<thead><tr>";
                        echo "<td>Beginn</td><td>Ende</td><td>Fahrzeug-Art</td><td>Tarif</td><td>Preis</td>";
                        echo "</tr></thead>";

                        echo "<tbody>";


                        foreach($data as $row) {
                            
                            echo "<td>" . $row["0"] . "</td>";
                            echo "<td>" . $row["1"] . "</td>";
                            echo "<td>" . $row["2"] . "</td>";
                            echo "<td>" . $row["3"] . "</td>";
                            echo "<td>" . $row["4"] . " €" . "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</tbody>";
                        echo "</table>";

                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>