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
            </div>
            
        </div><i id="iconoBasura" class="fa-solid fa-trash" onclick="location.href='eliminarCita.php?id=$id_cita';"></i></div></div>
    </div>
EOS;
    return $contenido;
}
