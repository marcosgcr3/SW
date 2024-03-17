<?php
use es\ucm\fdi\aw\productos\Producto;

require_once __DIR__.'/includes/config.php';

require_once 'includes/src/productos/producto.php';




$nombre = filter_input(INPUT_GET, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);


Producto::borrar($nombre);
header('Location: tienda.php');


