<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/vehiculos/listado_vehiculos.php';

require_once 'includes/src/vehiculos/vehiculo.php';

$tituloPagina = 'Alquiler';

$contenidoPrincipal = '';
$conn = Aplicacion::getInstance()->getConexionBd();
$sql = "SELECT * FROM vehiculos WHERE disponibilidad='si'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contenidoPrincipal .= elVehiculo($row);
    }
    $result->free();
} else {
    $contenidoPrincipal .= sinVehiculo();
}

if( $app->esAdmin() ){
    $contenidoPrincipal.= añadirVehiculo();
}
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
