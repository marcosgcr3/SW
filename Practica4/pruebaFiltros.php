<?php

require_once 'includes/config.php';

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\vehiculos\vehiculo;

require_once 'includes/src/vehiculos/listado_vehiculos.php';


$request = filter_input(INPUT_GET,'request', FILTER_SANITIZE_STRING, 1);

$html = '';
/*
$vehiculos = vehiculo::listaVehiculosMarca($request);

$html = '';

foreach($vehiculos as $vehiculo){
    $archivado = $vehiculo->getArchivado();
    $matricula = $vehiculo->getMatricula();
    $marca = $vehiculo->getMarca();
    $modelo = $vehiculo->getModelo();
    $precio = $vehiculo->getPrecio();
    $year = $vehiculo->getYear();
    $imagen = $vehiculo->getImagen();
    $html .=<<<EOS
    <div class="producto">
        <div class="producto-info">
            <img src="$imagen" alt="imagen" class="producto-imagen">
            <div class="producto-detalle">
                <h2>$marca : $modelo ($year)</h2>
                <p>$matricula</p>
                <p>Precio: $precio&euro;</p>
                <p>Archivado: $archivado</p>   
            </div>
        </div>
    </div>
    EOS;
}


*/
if ($request === 'nada') {

    Vehiculo::comprobarDisponibilidadTodos();
    // Alquilar::comprobarFecha();
    $html .= "<div class = prueba>";
    $html .= listavehiculos();
    $html .= "</div>";


    if( $app->esAdmin() ){
        $html.= añadirVehiculo();
    }
} else {
    Vehiculo::comprobarDisponibilidadTodos();
    // Alquilar::comprobarFecha();
    $html .= "<div class = prueba>";
    $html .= listavehiculosPorMarca($request);
    $html .= "</div>";

    if( $app->esAdmin() ){
        $html.= añadirVehiculo();
    }
}

echo $html;

