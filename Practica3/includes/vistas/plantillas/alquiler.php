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
    $contenido="";
    $contenido.=<<<EOS
    <div class="producto">
    
        <div class="producto-info">
        
        <img src="$imagen" alt="imagen" class="producto-imagen">
        <div class="producto-detalle">
        <h2>$marca:  $modelo</h2>
            <p>Fecha de inicio: $fechaIni</p>
            <p>Fecha de fin: $fechaFin</p>
            <p>Precio: $precio&euro;</p>
       
    
EOS;    
    $app = Aplicacion::getInstance();
    if ($app->esAdmin()) {
        //$contenido .='</div><i id="iconoBasura" class="fa-solid fa-trash" onclick="location.href=\'borrarVehiculo.php?matricula=' . $matricula . '\';"></i></div></div>';
    } else {
        
        $contenido .= <<<EOS
            </div>
            <form id="formBorrarAlquiler_$id" action="eliminarAlquiler.php" method="post">
                <input type="hidden" name="id_alquiler" value="$id">
            </form>
            <i id="iconoBasura" class="fa-solid fa-trash" onclick="document.getElementById('formBorrarAlquiler_$id').submit();"></i>
            </div></div>
       
            EOS;
    }

    return $contenido;
}
