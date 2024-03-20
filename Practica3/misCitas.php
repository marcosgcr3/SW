<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/citas/listado_citas.php';
require_once 'includes/src/citas/horarioMecanico.php';
require_once 'includes/src/productos/producto.php';
require_once 'procesaHorarioDisp.php';

$tituloPagina = 'Mis Citas';

$contenidoPrincipal = '';

$contenidoPrincipal .= listaCitas();
$contenidoPrincipal .= newCita();

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
