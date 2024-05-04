<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';

function generarDesplegableHorario($dia) {
    $conn = Aplicacion::getInstance()->getConexionBd();

    // Obtener el total de mecánicos
    $sql_count = "SELECT COUNT(*) AS total_mecanicos FROM usuarios WHERE rol = 'mecanico'";
    $result_count = $conn->query($sql_count);
    
    if ($result_count->num_rows > 0) {
        $row_count = $result_count->fetch_assoc();
        $total_mecanicos = $row_count['total_mecanicos'];
        $result_count->free();

        // Inicializar horario
        $horario = range(9, 17);
        $unavailableHours = [];

        // Consulta para obtener citas para el día seleccionado
        $sql_citas = "SELECT HOUR(startDate) as hora, COUNT(*) as total_citas FROM citas WHERE DATE(startDate) = '$dia' GROUP BY HOUR(startDate)";
        $result_citas = $conn->query($sql_citas);

        if ($result_citas->num_rows > 0) {
            while ($row_citas = $result_citas->fetch_assoc()) {
                $hora = $row_citas['hora'];
                $total_citas = $row_citas['total_citas'];

                // Si hay menos citas que mecánicos, la hora está disponible
                if ($total_citas < $total_mecanicos) {
                    $unavailableHours[] = $hora;
                }
            }
        }

        // Filtrar las horas disponibles
        $horasDisponibles = array_diff($horario, $unavailableHours);

        // Generar HTML para las opciones del desplegable
        $html = "";
        foreach ($horasDisponibles as $hora) {
            $html .= "<option value='$hora'>$hora:00</option>";
        }

        return $html;
    }

    return '<option value="">Seleccione una hora</option>';
}
