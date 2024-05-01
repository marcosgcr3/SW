<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';

function horarioDisponible($dia){
    $conn = Aplicacion::getInstance()->getConexionBd();
    $sql_count = "SELECT COUNT(*) AS total_mecanicos FROM usuarios WHERE rol = 'mecanico'";
    $sql = "SELECT id FROM usuarios WHERE rol = 'mecanico'";
    $result_count = $conn->query($sql_count);
    if ($result_count->num_rows > 0) {
        // Obtener el recuento total de mecánicos
        $row_count = $result_count->fetch_assoc();
        $total_mecanicos = $row_count['total_mecanicos'];

        // Liberar el resultado
        $result_count->free();

        $result = $conn->query($sql);
        $horario = range(9, 17);
        $resultado = $horario;
        $unavailableHours = [];

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            for ($hora = 9; $hora < 18; $hora++) {
                $mapa[$hora] = $total_mecanicos;
            }

            $sql2 = "SELECT HOUR(startDate) as hora FROM citas WHERE DATE(startDate) = '$dia'";
            $result2 = $conn->query($sql2);
            
            while ($row2 = $result2->fetch_assoc()) {
                $hora = $row2["hora"];
                $mapa[$hora] -= 1;
                if ($mapa[$hora] == 0) {
                    $unavailableHours[] = $hora;
                }
            }
            $resultado = array_diff($horario, $unavailableHours);
        }
    }
    return $resultado;
}
function generarDesplegableHorario($dia) {
    $horasDisp = horarioDisponible($dia);
    $html = "";
    foreach ($horasDisp as $hora) {
        $html .= "<option value='$hora'>$hora:00</option>";
    }
    $html .= "</select>";
    return $html;
}