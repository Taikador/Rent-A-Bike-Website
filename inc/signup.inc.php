<?php
if (isset($_POST["submit"])) {

    require_once 'db.inc.php';

    $firstname      = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lastname       = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $telephone      = mysqli_real_escape_string($conn, $_POST["telephone"]);
    $email          = mysqli_real_escape_string($conn, $_POST["email"]);
    $password       = mysqli_real_escape_string($conn, $_POST["password"]);
    $pwdRepeat      = mysqli_real_escape_string($conn, $_POST["passwordRepeat"]);
    $street         = mysqli_real_escape_string($conn, $_POST["street"]);
    $postalcode     = mysqli_real_escape_string($conn, $_POST["postalcode"]);

    require_once 'functions.inc.php';

    if (invalidEmail($email) !== false) {
        header("location: ../index.php?error=invalidemail");
        exit();
    }
    if (UsernameExists($conn, $email) !== false) {
        header("location: ../index.php?error=usernametaken");
        exit();
    }
    if (HumanNameExists($conn, $firstname, $lastname) !== false) {
        header("location: ../index.php?error=humanexist");
        exit();
    }
    
    createUser($conn, $firstname, $lastname, $telephone, $email, $password, $street, $postalcode);

}