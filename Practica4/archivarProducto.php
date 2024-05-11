<?php
use es\ucm\fdi\aw\productos\producto;

require_once __DIR__.'/includes/config.php';





$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$producto = Producto::buscaPorNombre($nombre);

Producto::archivarProducto($producto);
header('Location: tienda.php');


