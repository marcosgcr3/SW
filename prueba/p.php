<?php
// Crear un array de eventos (aquí puedes obtener tus eventos desde la base de datos)
$events = array(
    array(
        'title' => 'Evento 1',
        'start' => '2024-04-25T10:00:00',
        'end' => '2024-04-25T12:00:00'
    ),
    array(
        'title' => 'Evento 2',
        'start' => '2024-04-26T14:00:00',
        'end' => '2024-04-26T16:00:00'
    ),
);

// Convertir el array a formato JSON y devolverlo
echo json_encode($events);
?>
