<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/productos/listado_tienda.php';

require_once 'includes/src/productos/producto.php';

$tituloPagina = 'Tienda';

$contenidoPrincipal = '';

$contenidoPrincipal .= <<<EOS

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="barra">
  <h2 class="filtros">Filtros</h3>
  <form method="post" action="veremos">
    <input type="text" name="nombreV"/>
    <button class="buscar" type="submit"><i class="fa fa-search"></i> </button>
  </form>  
  <h3 class="tipo" href="#">Tipo de producto</a>
  <h3 class="rango" href="#">Rango de precio</a>
</div>

EOS;
$contenidoPrincipal .= listaproductos();
   


if( $app->esAdmin() ){
    $contenidoPrincipal.= añadirProducto();
}
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
