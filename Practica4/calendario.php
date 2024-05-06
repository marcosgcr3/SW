<?php
require_once __DIR__.'/includes/config.php';
$tituloPagina = "Calendario";
$ev = filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);

/*if($app->esCliente()){
  $ev = 'misCitas.php';
}*/
if($app->esMecanico()){
  $rol = 'mecanico';
}



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
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
  <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>

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
        eventDidMount: function(info) {
          var event = info.event;
          var backgroundColor;
          switch (event.extendedProps.estado) {
            case 0:
              backgroundColor = 'green';
              break;
            case 1:
              backgroundColor = '#a89400';
              
              break;
            case 2:
              backgroundColor = 'red';
              break;
            default:
              backgroundColor = 'black';
              break;
          }
          event.setProp('backgroundColor', backgroundColor);
          var tooltip = new Tooltip(info.el, {
            title: event.title,
            placement: 'top',
            trigger: 'hover',
            container: 'body'
          });
        },
        
        events: '$ev',
        editable: false,
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
        color: 'black', // Color de los eventos
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
       /* eventResize: function(info) {
          var event = info.event;
          var e = {
            "id": event.id,
            "id_mecanico": event.id_mecanico,
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
            "id_mecanico": event.id_mecanico,
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
        },*/
        // Ejecutado al hacer click sobre un evento
        eventClick: function(info) {
          var event = info.event;
            if(event.extendedProps.estado == 1){
              if (confirm("¿Desea aceptar esta cita?")) {
                var id = event.id;
                $.ajax({
                    url: '$ev?idEvento=' + id,
                    contentType: 'application/json; charset=utf-8',
                    dataType: "json",
                    type: "POST", // Cambiado a POST para aceptar la cita
                    success: function() {
                        calendar.refetchEvents();
                        alert('Cita aceptada');
                    }
                    
                });
              }else{
              
                  var id = event.id;
                  $.ajax({
                      url: '$ev?idEvento=' + id,
                      contentType: 'application/json; charset=utf-8',
                      dataType: "json",
                      type: "POST", // Cambiado a POST para rechazar la cita
                      success: function() {
                          calendar.refetchEvents();
                          alert('Cita rechazada');
                      },
                      error: function(XMLHttpRequest, textStatus, errorThrown) {
                          alert("Status: " + textStatus);
                          alert("Error: " + errorThrown);
                      }
                  });
              }
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
              url: '$ev',
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
            width: 90%;
            height: 460px; /* Establece la altura fija del calendario */
            display: flex;
            justify-content: center;
            margin: 0 auto;
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
