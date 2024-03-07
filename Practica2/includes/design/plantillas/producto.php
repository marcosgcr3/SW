<?php
require_once 'includes/config.php';
require_once 'includes/acceso/addProducto.php';



$tituloPagina = 'Producto ';
function buildArticulo($nombre, $precio, $descripcion, $unidades, $imagen)
{
    return <<<EOS
<div class="producto">
    <div class="producto-info">
        <img src="$imagen" alt="imagen" class="producto-imagen">
        <div class="producto-detalle">
            <h2>$nombre</h2>
            <p>$descripcion</p>
            <p>Precio: $precio&euro;</p>
            <p>Unidades disponibles: $unidades</p>
            <button class="botoncarro">Añadir al carrito</button>
        </div>
    </div>
</div>
EOS;
}