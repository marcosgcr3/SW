<?php

require_once 'includes/config.php';

use es\ucm\fdi\aw\Aplicacion;
require_once 'includes/src/productos/listado_tienda.php';

require_once 'includes/src/productos/producto.php';

$min = filter_input(INPUT_GET,'min', FILTER_VALIDATE_INT, 1);
$max = filter_input(INPUT_GET,'max', FILTER_VALIDATE_INT, 1);
$categoria = filter_input(INPUT_GET,'categoria', FILTER_SANITIZE_STRING, 1);

$html = '';

if($categoria === 'nada' and empty($min) and empty($max)){
    $html .= "<div class = prueba>";
    $html .= listaproductos();
    $html .= "</div>";
}
else{
    if($categoria === 'nada' and (!empty($min) or !empty($max))){   //Por precio
        $html .= "<div class = prueba>";
        $html .= listaproductosPrecio($min, $max);
        $html .= "</div>";
    }
    elseif($categoria !== 'nada' and empty($min) and empty($max)){  //Por categoria
        $html .= "<div class = prueba>";
        $html .= listaproductosCategoria($categoria);
        $html .= "</div>";
    }
    else{   //Categoria y precio
        $html .= "<div class = prueba>";
        $html .= listaproductosFiltrados($min, $max, $categoria);
        $html .= "</div>";
    }
}

echo $html;

