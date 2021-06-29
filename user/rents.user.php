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
    <script src="https://kit.fontawesome.com/2deba413ff.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/svg+xml" href="../img/admin-dash.svg">
    <link rel="stylesheet" href="../css/user.css">
    <title>User Dashboard</title>

    <link rel="stylesheet" href="../css/fullcalender.css" />
    <link rel="stylesheet" href="../css/date.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


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
        events: 'calendar_inc/rent.calendar.load.php',
        selectable: true,
        selectHelper: true,
        eventClick: function(event) {
          var start = (event.start == null ? "Unbekannt" : $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss"));
          var end = (event.end == null ? "Unbekannt" : $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss"));
          var title = event.title;

          const formData = new FormData();
          fetch('', {
            method: "POST",
            body: formData
          }).then(function(response) {
            return response.text();
          }).then(function(text) {
            console.log(text);
          }).catch(function(error) {
            concole.error(error);
          }).then(function(onclick) {
            Swal.fire({
              position: 'center',
              titleText: 'Informationen:',
              html: "Ausleihe ID: " + event.id + "<br> Start: " + start + "<br> Ende: " + end + "<br> Preis: "+event.price + "€<br> Abzuholen in: " + event.station + "<br> Tarif: " + event.tarif + "<br> Art des Fahrzeugs: " + event.klasse,
              showConfirmButton: true,
            })
          })
        },
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
                    <a href="#">
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

            <div class="detailsUser">
              <div class="container">
                <div id="calendar"></div>
              </div>
            </div>
        </div>
    </div>
</body>
</html>