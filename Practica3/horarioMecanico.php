<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';

$tituloPagina = 'Horario del mecánico';

$contenidoPrincipal = '';

$conn = Aplicacion::getInstance()->getConexionBd();

if ($app->esMecanico()) {
    $sql = "SELECT * FROM Citas WHERE id_mecanico = {$_SESSION['id']}";
    $result = $conn->query($sql);

    // Array para almacenar las citas del mecánico
    $citasMecanico = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $citasMecanico[] = $row['fecha'];
        }
        $result->free();
    }

    // Generamos el horario de la semana del mecánico
    $horario = [];
    for ($hora = 9; $hora <= 17; $hora++) {
        for ($dia = 1; $dia <= 5; $dia++) {
            $celda = [];
            $celda['hora'] = sprintf("%02d:00 - %02d:00", $hora, $hora + 1);
            $fechaCelda = new DateTimeImmutable("next Monday +{$dia} days $hora:00:00");
            $celda['fecha'] = $fechaCelda->format('Y-m-d H:i:s');
            $celda['contenido'] = '';

            // Comprobamos si hay una cita en esta hora
            if (in_array($celda['fecha'], $citasMecanico)) {
                $celda['contenido'] = 'Trabajo';
            } else {
                $celda['contenido'] = 'Descanso';
            }

            $horario[] = $celda;
        }
    }

    // Generamos la tabla HTML del horario
    $contenidoPrincipal .= '<h2>Horario del mecánico</h2>';
    $contenidoPrincipal .= '<table>';
    $contenidoPrincipal .= '<thead>';
    $contenidoPrincipal .= '<tr>';
    $contenidoPrincipal .= '<th>Hora</th>';
    $contenidoPrincipal .= '<th>Lunes</th>';
    $contenidoPrincipal .= '<th>Martes</th>';
    $contenidoPrincipal .= '<th>Miércoles</th>';
    $contenidoPrincipal .= '<th>Jueves</th>';
    $contenidoPrincipal .= '<th>Viernes</th>';
    $contenidoPrincipal .= '</tr>';
    $contenidoPrincipal .= '</thead>';
    $contenidoPrincipal .= '<tbody>';
    foreach ($horario as $celda) {
        $contenidoPrincipal .= '<tr>';
        $contenidoPrincipal .= '<td>' . $celda['hora'] . '</td>';
        $contenidoPrincipal .= '<td>' . $celda['contenido'] . '</td>';
        $contenidoPrincipal .= '</tr>';
    }
    $contenidoPrincipal .= '</tbody>';
    $contenidoPrincipal .= '</table>';
} else {
    // Si el usuario no es mecánico, mostramos un mensaje de error
    $contenidoPrincipal .= '<p>No tienes permiso para ver el horario del mecánico.</p>';
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
