<?php
require_once 'includes/config.php';
require_once 'includes/acceso/addProducto.php';



$tituloPagina = 'Producto ';
function buildArticulo($nombre , $precio, $descripcion, $unidades, $imagen){
return<<<EOS
<div class="producto">
    <h2>$nombre</h2>
    <p>$precio </p>
    <p>$descripcion</p>
    <p>Unidades disponibles: $unidades</p>
    <img src="$imagen" alt="imagen" width="200" height="200">
</div>

EOS;

}