<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;

function buildArticulo($producto)
{
    $productos = '';
        
    $cantidad = 1;
    $nombre = $producto->getNombre();
    $unidades = $producto->getUnidades();
    $precio = $producto->getPrecio();
   
    $imagen = $producto->getImagen();
    $descripcion = $producto->getDescripcion();
    $productos .=  <<<EOS
    <div class="producto">
        <div class="producto-info">
            <img src="$imagen" alt="imagen" class="producto-imagen">
            <div class="producto-detalle">
                <h2>$nombre</h2>
                <p>$descripcion</p>
                <p>Precio: $precio&euro;</p>
                <p>Unidades disponibles: $unidades</p>
                <!-- Botones para ajustar cantidad -->
                <div class="cantidad-botones">
                    <button class="boton-disminuir" onclick="disminuirCantidad('$nombre', $unidades)">-</button>
                    <span id="$nombre"> $cantidad </span> 
                    <button class="boton-aumentar" onclick="aumentarCantidad('$nombre', $unidades)">+</button>
                </div> 
    EOS;

    $app = Aplicacion::getInstance();
    if ($app->esAdmin()) {
        // Enlace para sumar stock con método POST
        $productos .= <<<EOS
            <form action="sumarStock.php" method="post">
                <input type="hidden" name="nombre" value="$nombre">
                <input type="hidden" name="unidades" value="$cantidad">
                <button class="botoncarro" type="submit">Sumar</button>
            </form>
            <form id="formBorrarProducto_$nombre" action="borrarProducto.php" method="post">
                <input type="hidden" name="nombre" value="$nombre">
            </form>
            <i id="iconoBasura" class="fa-solid fa-trash" onclick="document.getElementById('formBorrarProducto_$nombre').submit();"></i>
        </div></div></div>
        EOS;
    } else {
        // Botón para añadir al carrito
        $productos .= <<<EOS
            <button class="botoncarro" onclick="location.href='addProductoAlCarro.php?nombre=$nombre&unidades=$cantidad';">Añadir al carrito</button>
        </div></div></div>
        EOS;
    }
                
    return $productos;
}
