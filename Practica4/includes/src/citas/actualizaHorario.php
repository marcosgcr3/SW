<?php

require_once 'procesaHorarioDisp.php'; // Incluir el archivo que contiene la función horarioDisponible

if (isset($_POST['dia'])) {
    $dia = $_POST['dia'];
    $html = '<option value="">Seleccione una hora</option>';
    $horasDisponibles = generarDesplegableHorario($dia);
    $html .= $horasDisponibles;
    echo $html;
} else {
    echo '<option value="">Seleccione una hora</option>'; // Por si acaso no se proporciona una fecha válida
}
