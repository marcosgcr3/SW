<?php

require_once 'includes/config.php';
require_once 'includes/src/Producto/producto.php';
require_once 'includes/acceso/autorizacion.php';
require_once 'includes/acceso/addProducto.php';


$nombre = filter_input(INPUT_GET, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);

$unidades = filter_input(INPUT_GET, 'unidades', FILTER_SANITIZE_SPECIAL_CHARS);

$producto = Producto::buscaPorNombre($nombre);
Producto::crea($producto->getNombre(), $producto->getPrecio(), $producto->getDescripcion(), $producto->getUnidades() + $unidades, $producto->getImagen());

header('Location: tienda.php');

