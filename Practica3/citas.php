<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\citas\citas;

require_once 'includes/config.php';
require_once 'includes/src/citas/listado_citas.php';

require_once 'includes/src/vehiculos/vehiculo.php';

$tituloPagina = 'Cita';

$contenidoPrincipal = '';
    Citas::comprobarFecha();
    $contenidoPrincipal .= newCita();

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);