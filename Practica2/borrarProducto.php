<?php

require_once 'includes/config.php';
require_once 'includes/src/Producto/producto.php';
require_once 'includes/acceso/autorizacion.php';
require_once 'includes/acceso/addProducto.php';


$producto = Producto::buscaPorNombre($nombre);

$contenidoPrincipal=<<<EOS

<h1>hola: <?php echo $nombre; ?></h1>
EOS;



require 'includes/design/comunes/layout.php';