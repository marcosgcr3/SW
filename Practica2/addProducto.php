<?php
require_once 'includes/config.php';
require_once 'includes/acceso/addProducto.php';


$tituloPagina = 'Producto añadido';

$htmlFormProducto = buildFormularioProducto();
$contenidoPrincipal=<<<EOS
<h1>Agregar Producto</h1>
$htmlFormProducto
EOS;

require 'includes/design/comunes/layout.php';