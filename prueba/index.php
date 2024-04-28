<?php
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js'></script>
</head>
<body>
    <div id='calendar'></div>

    <script>
        $(document).ready(function() {
            // Inicializar FullCalendar
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: 'events.php' // Este es el archivo PHP que proporcionará los eventos
            });
            calendar.render();
        });
    </script>
</body>
</html>
