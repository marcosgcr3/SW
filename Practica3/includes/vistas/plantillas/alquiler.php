<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\vehiculos\Vehiculo;

function buildAlquiler($alquiler)
{
    $id = $alquiler->getId();
    $id_vehiculo = $alquiler->getIdVehiculo();
    $fechaIni = $alquiler->getFechaIni();
    $fechaFin = $alquiler->getFechaFin();
    $precio = $alquiler->getPrecioFinal();
    
    
    $vehiculo = Vehiculo::buscaPorId($id_vehiculo);
    $imagen = $vehiculo->getImagen();
    $marca = $vehiculo->getMarca();
    $modelo = $vehiculo->getModelo();
    $contenido=<<<EOF
    <div class="alquiler">
        <h2>$marca:  $modelo</h2>
        <img src="$imagen" alt="imagen" class="producto-imagen">
        <div class="alquiler-info">
            <p>Fecha de inicio: $fechaIni</p>
            <p>Fecha de fin: $fechaFin</p>
            <p>Precio: $precio&euro;</p>
        </div>
    </div>
EOF;    
    $app = Aplicacion::getInstance();
    if ($app->esAdmin()) {
        //$contenido .='</div><i id="iconoBasura" class="fa-solid fa-trash" onclick="location.href=\'borrarVehiculo.php?matricula=' . $matricula . '\';"></i></div></div>';
    } else {
        
        $contenido .= '<button class="botoncarro" onclick="location.href=\'eliminarAlquiler.php?id=' . $id . '&vehiculo=' . $id_vehiculo . '\';">Eliminar Alquiler</button></div></div></div>';
    }

    return $contenido;
}