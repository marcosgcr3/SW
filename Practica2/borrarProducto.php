<?php

require_once 'includes/config.php';
require_once 'includes/src/Producto/producto.php';
require_once 'includes/acceso/autorizacion.php';
require_once 'includes/acceso/addProducto.php';
$producto= Producto::buscaPorNombre($nombre);
$producto->eliminarProducto($producto->id_producto);
header('Location: tienda.php');