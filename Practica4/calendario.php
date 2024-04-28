<?php
require_once __DIR__.'/includes/config.php';
$tituloPagina = "Calendario";
$contenidoPrincipal = <<<HTML
<head>
  <title>JQuery Full Calendar</title>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" integrity="sha256-5veQuRbWaECuYxwap/IOE/DAwNxgm4ikX7nrgsqYp88=" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/moment@2.29.3/min/moment-with-locales.min.js" integrity="sha256-7WG1TljuR3d5m5qKqT0tc4dNDR/aaZtjc2Tv1C/c5/8=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js" integrity="sha256-XCdgoNaBjzkUaEJiauEq+85q/xi/2D4NcB3ZHwAapoM=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js" integrity="sha256-GcByKJnun2NoPMzoBsuCb4O2MKiqJZLlHTw3PJeqSkI=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/moment@5.11.0/main.global.min.js" integrity="sha256-oh4hswY1cPEqPhNdKfg+n3jATZilO3u2v7qAyYG3lVM=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha256-9SEPo+fwJFpMUet/KACSwO+Z/dKMReF9q4zFhU/fT9M=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script>
    
    $(document).ready(function() {
      var calendarEl = $('#calendar')[0]
      var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'timeGridWeek',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: 'eventos.php',
        editable: true,
        slotDuration: '01:00:00',
        businessHours: {
          // Días hábiles de lunes a viernes
          daysOfWeek: [1, 2, 3, 4, 5], // lunes=1, martes=2, ..., sábado=6, domingo=0
          // Horario de 9:00 a 18:00
          startTime: '09:00', // Hora de inicio
          endTime: '20:00' // Hora de fin
        },
        slotMinTime: '09:00', // Hora mínima
        slotMaxTime: '20:00', // Hora máxima
        
        //Ajustar formato del horario
        slotLabelInterval: { hours: 1 },
        slotLabelContent: function(slotInfo) {
          var date = new Date(slotInfo.date);
          var hour = date.getHours();
          var minute = date.getMinutes();
          // Ajustar el formato a 24 horas
          var formattedHour = hour.toString().padStart(2, '0');
          var formattedMinute = minute.toString().padStart(2, '0');
          return formattedHour + ':' + formattedMinute;
        },
        //Añadir eventos solo de lunes-viernes
        selectAllow: function(selectInfo) {
          // Verificar si es sábado o domingo
          if (selectInfo.start.getDay() === 6 || selectInfo.start.getDay() === 0) {
            return false; // No permitir selección en sábado y domingo
          }
          return true; // Permitir selección en los demás días
        },
        // Ejecutado al cambiar la duración del evento arrastrando
        eventResize: function(info) {
          var event = info.event;
          var e = {
            "id": event.id,
            "userId": event.userId,
            "start": moment(event.start).format("Y-MM-DD HH:mm:ss"),
            "end": moment(event.end).format("Y-MM-DD HH:mm:ss"),
            "title": event.title
          };
          $.ajax({
            url: "eventos.php?idEvento=" + event.id,
            type: "PUT",
            contentType: 'application/json; charset=utf-8',
            dataType: "json",
            data: JSON.stringify(e),
            success: function() {
              calendar.refetchEvents();
              alert('Evento actualizado');
            }
          })
        },
        // Ejecutado al arrastrar un evento
        eventDrop: function(info) {
          var event = info.event;
          if (info.event.start.getDay() === 6 || info.event.start.getDay() === 0) {
            // Revertir el cambio (no permitir el arrastre a sábado o domingo)
            info.revert();
            // Mostrar un mensaje de alerta indicando que no se puede mover a sábado o domingo
            alert('No puedes arrastrar eventos a sábado o domingo');
            return;
         }
          var e = {
            "id": event.id,
            "userId": event.userId,
            "start": moment(event.start).format("Y-MM-DD HH:mm:ss"),
            "end": moment(event.end).format("Y-MM-DD HH:mm:ss"),
            "title": event.title
          };
          $.ajax({
            url: "eventos.php?idEvento=" + event.id,
            contentType: 'application/json; charset=utf-8',
            dataType: "json",
            type: "PUT",
            data: JSON.stringify(e),
            success: function() {
              calendar.refetchEvents();
              alert('Evento actualizado');
            }
          }); 
        },
        // Ejecutado al hacer click sobre un evento
        eventClick: function(info) {
          var event = info.event;
          if (confirm("Seguro que desea eliminar el evento?")) {
            var id = event.id;
            $.ajax({
              url: "eventos.php?idEvento=" + id,
              contentType: 'application/json; charset=utf-8',
              dataType: "json",
              type: "DELETE",
              success: function() {
                calendar.refetchEvents();
                alert('Evento eliminado');
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);
              }
            })
          }
        },
        selectable: true,
        select: function(info) {
          var start = info.start;
          var end = info.end;
          var allDay = info.allDay;
          var title = prompt("Introduzca descripción");
          if (title) {
            var e = {
              "start": moment(start).format("Y-MM-DD HH:mm:ss"),
              "end": moment(end).format("Y-MM-DD HH:mm:ss"),
              "title": title
            };
            $.ajax({
              url: "eventos.php",
              type: "POST",
              contentType: 'application/json; charset=utf-8',
              dataType: "json",
              data: JSON.stringify(e),
              success: function() {
                calendar.refetchEvents();
                alert('Evento añadido');
              }
            })
          }
        },
      });
      calendar.render();
    });
  </script>
      <style>
        /* Estilo para el contenedor del calendario */
        #calendar {
            width: 100%;
            height: 460px; /* Establece la altura fija del calendario */
           
        }
    </style>
</head>
<body>
  <div class="container">
    <div id="calendar"></div>
  </div>
</body>

HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
