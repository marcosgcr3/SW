<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;

function buildCita($id_cita,$fecha, $asunto )
{
    $contenido = <<<EOS
    <div class="cita">
        <div class="cita-info">
            <h2>$asunto</h2>
            <p>Fecha: $fecha</p>
            
            <i id="iconoBasura" class="fa-solid fa-trash" onclick="location.href='eliminarCita.php?id=$id_cita';"></i>
        </div>
    </div>
    EOS;
    return $contenido;
}
