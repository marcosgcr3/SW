<?php

require_once __DIR__.'/includes/config.php';

require_once 'includes/src/Productos/producto.php';



$nombre = filter_input(INPUT_GET, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);


Producto::borrar($nombre);
header('Location: tienda.php');


