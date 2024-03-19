<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\productos\Producto;
use es\ucm\fdi\aw\pedidos\Pedidos;


function buildArticulo($producto)
{
    $productos = '';
        
    $nombre = $producto->getNombre();
    $unidades = $producto->getUnidades();
    $precio = $producto->getPrecio();
    $id_producto = $producto->getId();
    $imagen = $producto->getImagen();
    $descripcion = $producto->getDescripcion();
    $id_usuario = $_SESSION['id'];
    $productos .=  <<<EOS
    <div class="producto">
        <div class="producto-info">
            <img src="$imagen" alt="imagen" class="producto-imagen">
            <div class="producto-detalle">
                <h2>$nombre</h2>
                <p>$descripcion</p>
                <p>Precio: $precio&euro;</p>
                <p>Unidades disponibles: $unidades</p>
                <!-- FORM -->
                <form action="addProductoAlCarro.php" method="POST">
                    <input type="hidden" name="id" value={$_SESSION['id']}>
                    <input type="hidden" name="id_producto" value="$id_producto">
                    <input type="number" name="unidades" min="1" max="$unidades">
                    <button type="submit">Añadir al carrito</button>
                </form>
            </div>
            
    </div></div></div>';
    EOS;
        
                
    return $productos;
}
