<?php
use es\ucm\fdi\aw\productos\producto;

require_once __DIR__.'/includes/config.php';





$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);


Producto::borrar($nombre);
header('Location: tienda.php');


