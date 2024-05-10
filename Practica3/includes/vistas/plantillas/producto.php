<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\productos\producto;
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
   
    if($unidades != 0){
        $productos .=  <<<EOS
        <div class="producto">
            <div class="producto-info">
                <img src="$imagen" alt="imagen" class="producto-imagen">
                <div class="producto-detalle">
                    <h2>$nombre</h2>
                    <p>$descripcion</p>
                    <p>Precio: $precio&euro;</p>
                    <p>Unidades disponibles: $unidades</p>
                
        EOS;
    }
    
    $app = Aplicacion::getInstance();
    if ($app->esAdmin() && $unidades != 0) {
        // Enlace para sumar stock con método POST
        $productos .= <<<EOS
            <form action="sumarStock.php" method="post">
                <input type="hidden" name="nombre" value="$nombre">
                <input type="number" name="cantidad" min="1" value="1">
                <button type="submit" class="botoncarro">Sumar</button>
            </form>
            <form id="formBorrarProducto_$nombre" action="borrarProducto.php" method="post">
                <input type="hidden" name="nombre" value="$nombre">
            </form></div>
            <i id="iconoBasura" class="fa-solid fa-trash" onclick="document.getElementById('formBorrarProducto_$nombre').submit();"></i>
        </div></div>
        EOS;
    } else if ($unidades != 0){
        // Botón para añadir al carrito
        $productos .= <<<EOS
                <form action="addProductoAlCarro.php" method="POST">
                <input type="hidden" name="id_producto" value="$id_producto">
                <input type="number" name="unidades" min="1" max="$unidades" value="1">
                <button type="submit" class="botoncarro">Añadir al carrito</button>
            </form>
        </div>

        </div></div>
        EOS;
    }
                
    return $productos;
}
