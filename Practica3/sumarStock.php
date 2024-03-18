<?php

require_once __DIR__.'/includes/config.php';

require_once 'includes/src/Productos/producto.php';

use es\ucm\fdi\aw\productos\Producto;





$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);

$unidades = filter_input(INPUT_POST, 'unidades', FILTER_SANITIZE_SPECIAL_CHARS);






$producto = Producto::buscaPorNombre($nombre);
Producto::crea($producto->getNombre(), $producto->getPrecio(), $producto->getDescripcion(), $producto->getUnidades() + $unidades, $producto->getImagen());

header('Location: tienda.php');


