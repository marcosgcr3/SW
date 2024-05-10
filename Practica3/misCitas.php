<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/citas/listado_citas.php';
require_once 'includes/src/citas/horarioMecanico.php';
require_once 'includes/src/productos/producto.php';
require_once 'procesaHorarioDisp.php';

$tituloPagina = 'Mis Citas';

$contenidoPrincipal = '';

$contenidoPrincipal .= '<h1>Citas Activas</h1>';
$contenidoPrincipal .= listaCitas();
$contenidoPrincipal .= '<h1>Historial de Citas</h1>';
$contenidoPrincipal .= listaCitasHistorial();
$contenidoPrincipal .= newCita();

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
