<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/vehiculos/listado_vehiculos.php';

require_once 'includes/src/vehiculos/vehiculo.php';

$tituloPagina = 'Alquiler';

$contenidoPrincipal = '';

    $contenidoPrincipal .= listavehiculos();


if( $app->esAdmin() ){
    $contenidoPrincipal.= añadirVehiculo();
}
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
