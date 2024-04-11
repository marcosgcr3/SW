<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\citas\citas;

function buildCita($citas)
{
    $app = Aplicacion::getInstance();
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
                    
                    <form id="formBorrarCita_$id_cita" action="eliminarCita.php" method="post">
                        <input type="hidden" name="id_cita" value="$id_cita">
                    </form></div>
            EOS;
    if(($app->usuarioLogueado() || $app->esAdmin()) && !$app->esMecanico()){
        $contenido .= <<<EOS
            <i id="iconoBasura" class="fa-solid fa-trash" onclick="document.getElementById('formBorrarCita_$id_cita').submit();"></i>
        </div>
        EOS;
    }else{
        $contenido .= '</div>';
    }

    return $contenido;
}
function buildCitaH($citas)
{
    $asunto = $citas->getAsunto();
    $contenido = <<<EOS
    <div class="producto">
        <h2>$asunto</h2>
    </div>
    EOS;




    return $contenido;
}