<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\vehiculos\Vehiculo;

function buildAlquiler($id_vehiculo,$fechaIni, $fechaFin, $precio)
{
    $vehiculo = Vehiculo::buscaPorId($id_vehiculo);
    $contenido=<<<EOF
    <div class="alquiler">
        <h2>$vehiculo->getMarca():  $vehiculo->getModelo()</h2>
        <div class="alquiler-info">
            <p>Fecha de inicio: $fechaIni</p>
            <p>Fecha de fin: $fechaFin</p>
        </div>
    </div>
EOF;    
    $app = Aplicacion::getInstance();
    if ($app->esAdmin()) {
        //$contenido .='</div><i id="iconoBasura" class="fa-solid fa-trash" onclick="location.href=\'borrarVehiculo.php?matricula=' . $matricula . '\';"></i></div></div>';
    } else {
        //$contenido .= '<button class="botoncarro">Añadir al carrito</button></div></div></div>';
        //$contenido .= '<button class="botoncarro" onclick="location.href=\'alquilarVehiculo.php?matricula=' . $matricula . '&id_usuario=' . $_SESSION['id'] . '\';">Alquilar</button></div></div></div>';
    }

    return $contenido;
}