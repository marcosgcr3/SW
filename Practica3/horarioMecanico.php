<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/citas/listado_citas.php';


$tituloPagina = 'Mi Horario';

$contenidoPrincipal = '';

$contenidoPrincipal .= listaCitasMecanicoDias($_SESSION['id']);


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
