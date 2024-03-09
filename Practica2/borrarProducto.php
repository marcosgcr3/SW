<?php

require_once 'includes/config.php';
require_once 'includes/src/Producto/producto.php';
require_once 'includes/acceso/autorizacion.php';
require_once 'includes/acceso/addProducto.php';


$nombre = filter_input(INPUT_GET, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);


Producto::borrar($nombre);
header('Location: tienda.php');


