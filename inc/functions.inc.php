<?php
require_once 'db.inc.php';
?>
<?php

function emptyInputSignup($email, $password, $pwdRepeat)
{
    if (empty($email) || empty($password) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function UsernameExists($conn, $email)
{
    $sql    = "SELECT * FROM customer WHERE email = ?;";
    $stmt   = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=SELECTFAILED");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}
function HumanNameExists($conn, $firstname, $lastname)
{
    $sql    = "SELECT * FROM customer WHERE firstname = ? OR lastname = ?;";
    $stmt   = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=SELECTFAILED");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $firstname, $lastname);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}

function createUser($conn, $firstname, $lastname, $telephone, $email, $password, $street, $postalcode)
// 
// Role_id 1 = User
// Role_id 2 = Admin
// 
{
    $sql    = "INSERT INTO customer (firstname, lastname, telephone, email, password, street, ZIP, ID_Role) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt   = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=INSERTFAILED");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $role_id = 1;

    mysqli_stmt_bind_param($stmt, "ssssssii", $firstname, $lastname, $telephone, $email, $hashedPassword, $street, $postalcode, $role_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=none");
    exit();
}

function createEvent($conn, $starttime, $endtime, $id_customer, $id_tariff, $id_class, $chassis_number)
{

    $sql = "INSERT INTO rent-list (start, end, ID_Customer, ID_Tariff, ID_Class, chassis_number) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin/event.php?error=INSERTFAILED");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssiiii", $starttime, $endtime, $id_customer, $id_tariff, $id_class, $chassis_number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../admin/event.php?error=none");
    exit();
}


function getRoleName($conn, $userId)
{
    $query = $conn->query("SELECT ID_Role FROM customer WHERE ID_Customer = '$userId'");

    if ($query->num_rows <= 0) return null;

    $role_id = $query->fetch_assoc()['ID_Role'];

    $roleQuery = $conn->query("SELECT role FROM role WHERE ID_Role = '$role_id'");

    $role_name = $roleQuery->fetch_assoc()['role'];
    return $role_name;
}

function isAdmin($conn, $userId)
{
    $role_name = getRoleName($conn, $userId);
    if ($role_name == null) return null;
    return strcasecmp($role_name, "admin") == 0;
}

function isUser($conn, $userId)
{
    $role_name = getRoleName($conn, $userId);
    if ($role_name == null) return null;
    return strcasecmp($role_name, "user") == 0;
}

function getTownIdFromName($conn, $townName)
{
    $query = $conn->query("SELECT ZIP FROM town WHERE town ='$townName'");
    if ($query->num_rows <= 0) {
        return null;
    }
    $id = $query->fetch_assoc()['ZIP'];
    return $id;
}

function getClubIdFromName($conn, $className)
{

    $query = $conn->query("SELECT ID_Class FROM class WHERE name = '$className'");

    $id = $query->fetch_assoc()['ID_Class'];

    return $id;
}

function canDeleteRent($conn, $rent_id, $id_customer)
{
    $query = $conn->query("SELECT ID_Customer FROM rent-list WHERE ID_Rent = '$rent_id'");

    if ($query->num_rows <= 0) return false;

    $clubIdFromDatabase = $query->fetch_assoc()['ID_Customer'];

    return $clubIdFromDatabase == $id_customer;
}

function getClassFromId($conn, $classId)
{

    $query = $conn->query("SELECT name FROM class WHERE ID_Class = '$classId'");

    $className = $query->fetch_assoc()['name'];
    $classPrice = $query->fetch_assoc()['price'];

    return [$className, $classPrice];
}

function emptyInputLogin($email, $pwd)
{
    if (empty($email) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $email, $pwd)
{
    $usernameExists = UsernameExists($conn, $email, $email);

    if ($usernameExists === false) {
        header("location: ../login.php?error=wronglogin1");
        exit();
    }

    $pwdHashed  = $usernameExists['password'];
    $checkPwd   = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin2");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION['userid']     = $usernameExists['ID_Customer'];
        $_SESSION['email']      = $usernameExists['email'];
        $_SESSION['role']       = getRoleFromId($usernameExists['ID_Role']);
        header("location: ../index.php");
        exit();
    }
}

function getRoleFromId($id)
{

    switch ($id) {

        case 1:
            return "User";
            break;
        case 2:
            return "Admin";
            break;

        default:
            return "Watcher";
            break;
    }
}