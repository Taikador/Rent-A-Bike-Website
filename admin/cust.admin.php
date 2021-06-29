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
                    <a href="dash.admin.php">
                        <span class="icon"><i class="fa fa-home" aria-hidden="true"></i></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
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

            <div class="detailsCust">
                <div class="AllCustomers">
                    <div class="cardHeader">
                        <h2>Alle Kunden</h2>
                    </div>
                    <?php
                        include_once '../inc/db.inc.php';

                        $sql        = 'SELECT 
                                        customer.ID_Customer, customer.firstname, customer.lastname, customer.email, customer.telephone, customer.street, town.town
                                        FROM 
                                        customer
                                        INNER JOIN 
                                        town 
                                        ON 
                                        customer.ZIP = town.ZIP
                                        WHERE 
                                        ID_ROLE 
                                        NOT LIKE 
                                        2
                                        ';
                        $dbquery    = $conn->prepare($sql);
                        $dbquery    ->execute();
                        $result     = $dbquery->get_result();
                        $data       = $result->fetch_all();

                        echo "<table class='qtable' id='allcustomer-table'>";
                        echo "<thead><tr>";
                        echo "<td>Kunden ID</td><td>Vorname</td><td>Nachname</td><td>E-Mail</td><td>Telefon</td><td>Straße</td><td>Ort</td><td></td>";
                        echo "</tr></thead>";

                        echo "<tbody>";

                        foreach($data as $row) {
                            $cssClasses = (isset($_POST['submit_search']) && in_array($row[0], $ids)) ? 'highlight' : '';

                            echo '<tr class="' . $cssClasses . '">';
                            echo "<td>" . $row["0"] . "</td>";
                            echo "<td>" . $row["1"] . "</td>";
                            echo "<td>" . $row["2"] . "</td>";
                            echo "<td>" . $row["3"] . "</td>";
                            echo "<td>" . $row["4"] . "</td>";
                            echo "<td>" . $row["5"] . "</td>";
                            echo "<td>" . $row["6"] . "</td>";
                            echo "<td>" . "<a href = '../inc/cust-delete.inc.php?rn=$row[0]'>" . " <i class='fas fa-trash'></i>" . "</td>";
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
            let main        = document.querySelector('.first_prime');
            toggle.classList.toggle('active');
            navigation.classList.toggle('active');
            main.classList.toggle('active');
        }
    </script>
</body>
</html>