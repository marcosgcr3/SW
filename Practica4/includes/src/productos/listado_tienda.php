<?php 


require_once 'includes/config.php';
require_once 'includes/vistas/plantillas/producto.php';

use es\ucm\fdi\aw\productos\producto;

function listaproductos()
{
    $productos = Producto::listaProducto();
    $contenido = '';
    if (empty($productos)) {
        return sinArticulos();
    }

    foreach ($productos as $producto) {
        $contenido .= elArticulo($producto);
    }
    //
    return $contenido;
}

function elArticulo($producto){
   $contenido = buildArticulo($producto);
   return $contenido;
}

function sinArticulos(){
    $contenido = "<tr><td colspan='4'>No hay productos disponibles</td></tr>";
    return $contenido;
}

function añadirProducto(){
    $contenido = <<<EOS
    <button class="botonIni" onclick="location.href='addProducto.php'">Añadir producto</button>
    EOS;
    return $contenido;
}
