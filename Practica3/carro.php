<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/pedidos/listadoPedidos.php';
require_once 'includes/src/productos/producto.php';

$tituloPagina = 'Carrito';

$contenidoPrincipal = '';
if( $app->esAdmin() ){
    $contenidoPrincipal.= "Nada";
}
else{
    $contenidoPrincipal .= carrito();
}
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);     
        