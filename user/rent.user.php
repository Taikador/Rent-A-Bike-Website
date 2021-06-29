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
    <script src="https://kit.fontawesome.com/2deba413ff.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/svg+xml" href="../img/user-dash.svg">
    <title>User Dashboard</title>

    <link rel="stylesheet" href="../css/fullcalender.css" />


    <link rel="stylesheet" href="../css/date.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://rawgit.com/tempusdominus/bootstrap-4/master/build/js/tempusdominus-bootstrap-4.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>



    <link rel="stylesheet" href="../css/user.css">

    <script>
        $(document).ready(function() {
            var calendar = $('#calendar').fullCalendar({
                eventStartEditable: false,
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                selectable: true,
                selectHelper: true,
                select: function(event) {
                    var tarifName = null;
                    var start = null;
                    var className = null;


                    var inputOptionsPromise = new Promise(function(resolve) {
                        $.ajax({
                            url: "calendar_inc/rent.inc.php",
                            type: "POST",
                            data: {
                                file_id: 0
                            },
                            success: function(dataArray) {
                                const parsed = JSON.parse(dataArray);

                                tarife = []

                                for ($i = 0; $i < parsed.length; $i++) {
                                    tarife[$i] = parsed[$i]['name'];
                                }

                                setTimeout(function() {
                                    resolve({
                                        tarife: tarife
                                    })
                                })

                                Swal.fire({
                                    title: "Start / Tarif auswählen",
                                    showDenyButton: true,
                                    denyButtonText: "Abbrechen",
                                    confirmButtonText: "Weiter",
                                    input: "select",
                                    inputOptions: inputOptionsPromise,
                                    html: 'Start: <input type="text" name="payment_day" class="datetimepicker-input swal2-input" autocomplete="off" data-toggle="datetimepicker" data-target="#payment_day" id="payment_day"> <br> Tarif:',
                                    onOpen: function() {
                                        $('#payment_day').datetimepicker({});
                                    },
                                    preConfirm: function(value) {
                                        tarifName = tarife[value];
                                        start = $('#payment_day').val();
                                        return new Promise((resolve, reject) => {
                                            resolve({
                                                start: $('#payment_day').val(),
                                                tarif_id: value
                                            })
                                        });
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        var inputOptionsPromiseTwo = new Promise(function(resolve) {
                                            $.ajax({
                                                url: "calendar_inc/rent.inc.php",
                                                type: "POST",
                                                data: {
                                                    file_id: 1
                                                },
                                                success: function(dataArray) {
                                                    const parsed = JSON.parse(dataArray);
                                                    classes = []

                                                    for ($i = 0; $i < parsed.length; $i++) {
                                                        classes[$i] = parsed[$i]['art'];
                                                    }

                                                    setTimeout(function() {
                                                        resolve({
                                                            classes: classes
                                                        })
                                                    })

                                                    Swal.fire({
                                                        title: "Klassenart auswählen",
                                                        showDenyButton: true,
                                                        denyButtonText: "Abbrechen",
                                                        confirmButtonText: "Jetzt Mieten",
                                                        input: "select",
                                                        inputOptions: inputOptionsPromiseTwo,
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            className = classes[result.value];
                                                            $.ajax({
                                                                url: "calendar_inc/bill.inc.php",
                                                                type: "POST",
                                                                data: {
                                                                    class: className,
                                                                    tarif: tarifName,
                                                                    start: start,
                                                                },
                                                            })
                                                            window.location = "rents.user.php";
                                                        }
                                                    });
                                                },
                                            });
                                        });
                                    }
                                })
                            },
                        });
                    });
                }
            });
        });
    </script>

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
                    <a href="#">
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

            <div class="detailsCust">

                <div class="container">
                    <div id="calendar"></div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleMenu() {
            let toggle = document.querySelector('.toggle');
            let navigation = document.querySelector('.navigation');
            let main = document.querySelector('.main');
            toggle.classList.toggle('active');
            navigation.classList.toggle('active');
            main.classList.toggle('active');
        }
    </script>
</body>


</html>