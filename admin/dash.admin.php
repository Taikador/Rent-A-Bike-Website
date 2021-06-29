<?php
session_start();
require_once '../inc/db.inc.php';
require_once '../inc/functions.inc.php';

if (isset($_SESSION)) {
    if (!isAdmin($conn, $_SESSION['userid'])) {
        header("location: ../error/error_403_page.php");
    }
} else {
    header("location: ../error/error_403_page.php");
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2deba413ff.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/svg+xml" href="../img/admin-dash.svg">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title>Admin Dashboard</title>
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
                    <a href="cust.admin.php">
                        <span class="icon"><i class="fa fa-users" aria-hidden="true"></i></span>
                        <span class="title">Kunden</span>
                    </a>
                </li>
                <li>
                    <a href="rent.admin.php">
                        <span class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        <span class="title">Buchungen</span>
                    </a>
                </li>
                <li>
                    <a href="veh.admin.php">
                        <span class="icon"><i class="fa fa-bicycle" aria-hidden="true"></i></span>
                        <span class="title">Fahrzeuge</span>
                    </a>
                </li>
                <li>
                    <a href="rep.admin.php">
                        <span class="icon"><i class="fa fa-wrench" aria-hidden="true"></i></span>
                        <span class="title">Reparaturen</span>
                    </a>
                </li>
                <li>
                    <a href="sett.admin.php">
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

        <div class="first_prime">
            <div class="topbar">
                <div class="toggle" onclick="toggleMenu();"></div>
            </div>

            <div class="cardBox">
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
                        <div class="numbers"><?php include_once '../inc/db.inc.php'; $sql = "SELECT * FROM customer WHERE ID_Role NOT LIKE 2"; $statement = $conn->prepare($sql); $statement->execute(); $result=$statement->get_result(); $count=$result->num_rows; echo $count; ?></div>
                        <div class="cardName">Anzahl der Kunden</div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers"><?php include_once '../inc/db.inc.php'; $sql = "SELECT * FROM `rent-list`"; $statement = $conn->prepare($sql); $statement->execute(); $result=$statement->get_result(); $count=$result->num_rows; echo $count; ?></div>
                        <div class="cardName">Anzahl der Vermietungen</div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers"><?php include_once '../inc/db.inc.php'; $result = mysqli_query($conn, "SELECT SUM(price) AS value_sum FROM `rent-list`"); $row = mysqli_fetch_assoc($result); $sum = $row['value_sum']; echo "$sum €" ?></div>
                        <div class="cardName">Einnahmen</div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                </div>
            </div>

            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Letzten Buchungen</h2>
                        <a href="rent.admin.php" class="btn">Alle ansehen</a>
                    </div>
                    <?php
                        include_once '../inc/db.inc.php';

                        $sql        = 'SELECT 
                                        customer.lastname, `rent-list`.`start`, class.name, tariff.name
                                        FROM `rent-list`
                                        INNER JOIN customer ON customer.ID_Customer = `rent-list`.`ID_Customer`
                                        INNER JOIN class ON class.ID_Class = `rent-list`.`ID_Class`
                                        INNER JOIN tariff ON tariff.ID_Tariff = `rent-list`.`ID_Tariff`';
                        $dbquery    = $conn->prepare($sql);
                        $dbquery    ->execute();
                        $result     = $dbquery->get_result();
                        $data       = $result->fetch_all();

                        echo "<table class='qtable' id='booking-table'>";
                        echo "<thead><tr>";
                        echo "<td>Kunde</td><td>Beginn</td><td>Gerät</td><td>Tarif</td>";
                        echo "</tr></thead>";

                        echo "<tbody>";

                        foreach($data as $row) {
                            
                            echo "<td>" . $row["0"] . "</td>";
                            echo "<td>" . $row["1"] . "</td>";
                            echo "<td>" . $row["2"] . "</td>";
                            echo "<td>" . $row["3"] . "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</tbody>";
                        echo "</table>";

                    ?>
                </div>
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Neue Kunden</h2>
                        <a href="cust.admin.php" class="btn">Alle ansehen</a>
                    </div>
                    <?php
                        include_once '../inc/db.inc.php';

                        $sql        = 'SELECT 
                                        customer.firstname, customer.lastname, town.town
                                        FROM 
                                        customer
                                        INNER JOIN
                                        town ON town.ZIP = customer.ZIP
                                        WHERE
                                        ID_Role
                                        NOT LIKE 2';
                        $dbquery    = $conn->prepare($sql);
                        $dbquery    ->execute();
                        $result     = $dbquery->get_result();
                        $data       = $result->fetch_all();

                        echo "<table class='qtable' id='customer-table'>";
                        echo "<thead><tr>";
                        echo "<td>Vorname</td><td>Nachname</td><td>Stadt</td>";
                        echo "</tr></thead>";

                        echo "<tbody>";

                        foreach($data as $row) {
                            
                            echo "<td>" . $row["0"] . "</td>";
                            echo "<td>" . $row["1"] . "</td>";
                            echo "<td>" . $row["2"] . "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</tbody>";
                        echo "</table>";

                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMenu() {
            let toggle      = document.querySelector('.toggle');
            let navigation  = document.querySelector('.navigation');
            let main        = document.querySelector('.main');
            toggle.classList.toggle('active');
            navigation.classList.toggle('active');
            main.classList.toggle('active');
        }
    </script>
</body>
</html>