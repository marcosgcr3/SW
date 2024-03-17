<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/alquilar/listaAlquileres.php';

require_once 'includes/src/productos/producto.php';

$tituloPagina = 'Mis Alquileres';

$contenidoPrincipal = '';



    $contenidoPrincipal .= listaAlquileres();
    
 

    

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
