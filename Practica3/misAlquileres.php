<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/alquilar/listaAlquileres.php';

require_once 'includes/src/productos/producto.php';

$tituloPagina = 'Mis Alquileres';

$contenidoPrincipal = '';


    $contenidoPrincipal .= '<h1>Alquileres Activos</h1>';
    $contenidoPrincipal .= listaAlquileres();
    $contenidoPrincipal .= '<h1>Alquileres Pendientes de Devolver</h1>';
    $contenidoPrincipal .= listaAlquileresPendientesDevolver();
    $contenidoPrincipal .= '<h1>Historial de Alquileres</h1>';
    $contenidoPrincipal .= listaHistorialAlquileres();

 

    

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
