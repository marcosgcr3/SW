<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/productos/listado_tienda.php';

require_once 'includes/src/productos/producto.php';

$tituloPagina = 'Tienda';

$contenidoPrincipal = '';



   
$contenidoPrincipal .= listaproductos();
   


if( $app->esAdmin() ){
    $contenidoPrincipal.= añadirProducto();
}
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
