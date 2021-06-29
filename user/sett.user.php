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
            let main        = document.querySelector('.main');
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
                    <a href="dash.user.php">
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
                    <a href="#">
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

            <div class="DatacardBox">
                <div class="Datacard">
                    <div>
                        <div class="DataName"><?php include_once '../inc/db.inc.php'; $id = $_SESSION['userid']; $sql = mysqli_query($conn, "SELECT * FROM `customer` WHERE ID_Customer LIKE $id"); $row = mysqli_fetch_assoc($sql); $email = $row['email'];  echo $email;?></div>
                        <div class="DataDesc">Email-Adresse</div>
                        <div class="change_form">
                            <form class="change_box" action="../inc/changes/email.inc.php" method="POST">
                                <div class="changeBox w50">
                                    <input type="email" name="email" placeholder="Email ändern...">
                                </div>
                                <div class="changeBox w50" id="changebtn">
                                    <input type="submit" name="submit" value="Ändern" id="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-at"></i>
                    </div>
                </div>
                <div class="Datacard">
                    <div>
                        <div class="DataName"><?php include_once '../inc/db.inc.php'; $id = $_SESSION['userid']; $sql = mysqli_query($conn, "SELECT * FROM `customer` WHERE ID_Customer LIKE $id"); $row = mysqli_fetch_assoc($sql); $zip = $row['ZIP']; $sqlt =mysqli_query($conn, "SELECT * FROM town WHERE ZIP LIKE $zip"); $ziprow = mysqli_fetch_assoc($sqlt); $town = $ziprow['town']; echo $town; ?></div>
                        <div class="DataDesc">Wohnort</div>
                        <div class="change_form">
                            <form class="change_box" action="../inc/changes/town.inc.php" method="POST">
                                <div class="changeBox w50">
                                <?php
                                    include_once '../inc/db.inc.php';
                                    $query = $conn->query("SELECT * FROM town");

                                    echo '<select name="town" id="town" class="dropdown" required>';
                                    echo '<option value="" disabled selected hidden>Wohnort ändern...</option>';
                                    while ($row = $query->fetch_assoc()) {
                                        echo "<option value='" . $row['ZIP'] ."'>" . $row['town'] ."</option>";
                                    }
                                    echo "</select>";
                                ?>
                                </div>
                                <div class="changeBox w50" id="changebtn">
                                    <input type="submit" name="submit" value="Ändern" class="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-home"></i>
                    </div>
                </div>
                <div class="Datacard">
                    <div>
                        <div class="DataName"><?php include_once '../inc/db.inc.php'; $sql = mysqli_query($conn, "SELECT * FROM `customer` WHERE ID_Customer LIKE $id"); $row = mysqli_fetch_assoc($sql); $street = $row['street'];  echo $street; ?></div>
                        <div class="DataDesc">Straße</div>
                        <div class="change_form">
                            <form class="change_box" action="../inc/changes/street.inc.php" method="POST">
                                <div class="changeBox w50">
                                    <input type="text" name="street" placeholder="Straße ändern...">
                                </div>
                                <div class="changeBox w50" id="changebtn">
                                    <input type="submit" name="submit" value="Ändern" class="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-road"></i>
                    </div>
                </div>
                <div class="Datacard">
                    <div>
                        <div class="DataName"><?php include_once '../inc/db.inc.php'; $sql = mysqli_query($conn, "SELECT * FROM `customer` WHERE ID_Customer LIKE $id"); $row = mysqli_fetch_assoc($sql); $phone = $row['telephone'];  echo $phone; ?></div>
                        <div class="DataDesc">Telefonnummer</div>
                        <div class="change_form">
                            <form class="change_box" action="../inc/changes/phone.inc.php" method="POST">
                                <div class="changeBox w50">
                                    <input type="text" name="phone" placeholder="Nummer ändern...">
                                </div>
                                <div class="changeBox w50" id="changebtn">
                                    <input type="submit" name="submit" value="Ändern" class="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-phone"></i>
                    </div>
                </div>
                <div class="Datacard">
                    <div>
                        <div class="DataName"><?php include_once '../inc/db.inc.php'; $id = $_SESSION['userid']; $sql = mysqli_query($conn, "SELECT * FROM `customer` WHERE ID_Customer LIKE $id"); $row = mysqli_fetch_assoc($sql); $firstname = $row['firstname'];  echo $firstname; ?></div>
                        <div class="DataDesc">Vorname</div>
                        <div class="change_form">
                            <form class="change_box" action="../inc/changes/firstname.inc.php" method="POST">
                                <div class="changeBox w50">
                                    <input type="text" name="firstname" placeholder="Vornamen ändern...">
                                </div>
                                <div class="changeBox w50" id="changebtn">
                                    <input type="submit" name="submit" value="Ändern" class="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-id-card"></i>
                    </div>
                </div>
                <div class="Datacard">
                    <div>
                        <div class="DataName"><?php include_once '../inc/db.inc.php'; $sql = mysqli_query($conn, "SELECT * FROM `customer` WHERE ID_Customer LIKE $id"); $row = mysqli_fetch_assoc($sql); $lastname = $row['lastname'];  echo $lastname; ?></div>
                        <div class="DataDesc">Nachname</div>
                        <div class="change_form">
                            <form class="change_box" action="../inc/changes/lastname.inc.php" method="POST">
                                <div class="changeBox w50">
                                    <input type="text" name="lastname" placeholder="Nachnamen ändern...">
                                </div>
                                <div class="changeBox w50" id="changebtn">
                                    <input type="submit" name="submit" value="Ändern" class="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-id-card"></i>
                    </div>
                </div>
                <div class="Datacard">
                    <div>
                        <div class="DataName">*******</div>
                        <div class="DataDesc">Passwort</div>
                        <div class="change_form">
                            <form class="change_box" action="../inc/changes/password.inc.php" method="POST">
                                <div class="changeBox w50">
                                    <input type="password" name="password" placeholder="Passwort ändern...">
                                </div>
                                <div class="changeBox w50" id="changebtn">
                                    <input type="submit" name="submit" value="Ändern" class="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="iconBox">
                        <i class="fas fa-unlock-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>