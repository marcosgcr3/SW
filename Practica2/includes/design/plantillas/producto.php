<?php
require_once 'includes/config.php';
require_once 'includes/acceso/addProducto.php';
require_once 'includes/src/Producto/producto.php';
require_once 'includes/Pedidos.php';



$tituloPagina = 'Producto ';
function buildArticulo($nombre, $precio, $descripcion, $unidades, $imagen)
{
    $cantidad = 1;
    $contenido = <<<EOS
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
                <button class="boton-aumentar" onclick="aumentarCantidad('$nombre', $unidades)">+</button>
                <span id="$nombre"> $cantidad </span>
                <button class="boton-disminuir" onclick="disminuirCantidad('$nombre', $unidades)">-</button>
            </div> 
            <button class="botoncarro" onclick="agregarAlCarrito('$nombre')">Añadir al carrito</button>
        </div>
    </div>
</div>
<script src="js/contadorProductos.js"></script>
EOS;

    
    if (esAdmin()) {
        
        $contenido .= '<i id="iconoBasura" class="fa-solid fa-trash" onclick="location.href=\'borrarProducto.php\'"></i></div></div></div>';
    }else{
        $contenido .= '</div></div></div>';
    }

   

    return $contenido;
}
