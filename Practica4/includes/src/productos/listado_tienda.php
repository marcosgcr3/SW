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

function listaproductosPrecio($min, $max)
{
    $productos = Producto::listaProductoPrecio($min,$max);
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

function listaproductosCategoria($categoria)
{
    $productos = Producto::listaProductoCategoria($categoria);
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

function listaproductosFiltrados($min, $max, $categoria)
{
    $productos = Producto::listaproductosFiltrados($min, $max, $categoria);
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
    $contenido = <<<EOS
    <div class="producto">
    <h3>No hay articulos con esas caracteristicas disponibles</h3>
    </div>
    EOS;
    return $contenido;
}

function añadirProducto(){
    $contenido = <<<EOS
    <button class="botonIni" onclick="location.href='addProducto.php'">Añadir producto</button>
    EOS;
    return $contenido;
}
