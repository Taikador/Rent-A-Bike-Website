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

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    
</body>
</html>