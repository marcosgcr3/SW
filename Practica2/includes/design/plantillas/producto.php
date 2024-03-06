<?php
require_once 'includes/config.php';
require_once 'includes/acceso/addProducto.php';



$tituloPagina = 'Producto ';
function buildArticulo($nombre , $precio, $descripcion, $unidades, $imagen){
return<<<EOS
<div class="producto">
    <h1>Producto</h1>
    <p>Nombre: $nombre</p>
    <p>Precio: $precio</p>
    <p>Descripción: $descripcion</p>
    <p>Unidades: $unidades</p>
    <p>Imagen: $imagen</p>
</div>

EOS;

}