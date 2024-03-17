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
            $productos .= '<button class="botoncarro" onclick="location.href=\'sumarStock.php?nombre=' . $nombre . '&unidades=\' + document.getElementById(\''.$nombre.'\').innerHTML;">sumar</button>
            </div><i id="iconoBasura" class="fa-solid fa-trash" onclick="location.href=\'borrarProducto.php?nombre=' . $nombre . '\';"></i></div></div>';
        } else {
            //$contenido .= '<button class="botoncarro">Añadir al carrito</button></div></div></div>';
            $productos .= '<button class="botoncarro" onclick="location.href=\'addProductoAlCarro.php?nombre=' . $nombre . '&unidades=' . $cantidad . '\';">Añadir al carrito</button></div></div></div>';
        }
        
                
    return $productos;
}
