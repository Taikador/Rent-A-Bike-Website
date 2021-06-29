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
                    <a href="#">
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

            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Alle Reparaturen</h2>
                    </div>
                    <?php
                        include_once '../inc/db.inc.php';

                        $sql        = 'SELECT 
                                        date, description, chassis_number
                                        FROM repairs
                                        ';
                        $dbquery    = $conn->prepare($sql);
                        $dbquery    ->execute();
                        $result     = $dbquery->get_result();
                        $data       = $result->fetch_all();

                        echo "<table class='qtable' id='allrepairs-table'>";
                        echo "<thead><tr>";
                        echo "<td>Datum</td><td>Beschreibung</td><td>Fahrzeug</td>";
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
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Neue Reparatur</h2>
                    </div>
                    <div class="input_form">
                        <form class="form_box" action="../inc/rep.inc.php" method="POST">
                            <div class="inputBox w50">
                                <input type= "text" id="datepicker" onfocus="(this.type='date')" name="date" required>
                                <span>Datum</span>
                            </div>
                            <div class="inputBox w100">
                                <textarea type= "" id="description"  name="desc" required></textarea>
                                <span>Beschreibung</span>
                            </div>
                            <div>
                            <?php
                                include_once '../inc/db.inc.php';
                                $query = $conn->query("SELECT * FROM vehicle");

                                echo '<select name="vehicle" id="dropDown" required>';
                                echo '<option value="" disabled selected hidden>Fahrzeug wählen</option>';
                                while ($row = $query->fetch_assoc()) {
                                    echo "<option value='" . $row['chassis_number'] ."'>" . $row['chassis_number'] ."</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                            <div class="inputBox w50" id="btn">
                                <input type="submit" name="submit" value="Speichern" id="submit">
                            </div>
                        </form>
                    </div>
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