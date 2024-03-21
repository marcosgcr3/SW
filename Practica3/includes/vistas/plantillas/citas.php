<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\citas\Citas;

function buildCita($citas)
{
    $id_cita = $citas->getId();
    $dia = $citas->getDia();
    $hora = $citas->getHora();
    $asunto = $citas->getAsunto();
    $contenido = <<<EOS
    <div class="producto">
        <div class="producto-info">
        <div class="producto-detalle">
            <h2>$asunto</h2>
            <p>Fecha: $dia, $hora:00</p>
            <p>ID: $id_cita</p>
            </div>
            
        <form id="formBorrarCita_$id_cita" action="eliminarCita.php" method="post">
            <input type="hidden" name="id_cita" value="$id_cita">
        </form></div>
        <i id="iconoBasura" class="fa-solid fa-trash" onclick="document.getElementById('formBorrarCita_$id_cita').submit();"></i>
    </div>
EOS;
    return $contenido;
}
