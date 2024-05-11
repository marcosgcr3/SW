<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/pedidos/listadoPedidos.php';
require_once 'includes/src/productos/producto.php';

$tituloPagina = 'Mis Pedidos';

$contenidoPrincipal = '';

$contenidoPrincipal .= '<h1>Pedidos realizados</h1>';
$contenidoPrincipal .= pedido();
$contenidoPrincipal .=<<<EOS
<button class="botonC" onclick="location.href='miCuenta.php'">Volver</button>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
