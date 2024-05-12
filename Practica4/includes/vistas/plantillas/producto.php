<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\productos\producto;
use es\ucm\fdi\aw\pedidos\Pedidos;


function buildArticulo($producto)
{
    $productos = '';
    
    $id = $producto->getId();
    $archivado = $producto->getArchivado();
    $nombre = $producto->getNombre();
    $unidades = $producto->getUnidades();
    $precio = $producto->getPrecio();
    $archivado = $producto->getArchivado();
    $id_producto = $producto->getId();
    $imagen = $producto->getImagen();
    $descripcion = $producto->getDescripcion();
   
    if($archivado == 0){ //si el producto NO esta archivado
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
    if ($app->esAdmin() && $archivado == 0) {
        // Enlace para sumar stock, borrar producto y editar producto
        $productos .= <<<EOS
            
            <form action="sumarStock.php" method="post">
                <input type="hidden" name="nombre" value="$nombre">
                <input type="number" name="cantidad" min="1" value="1">
                <button type="submit" class="botoncarro">Sumar</button>
            </form>
            </div>

            <div class="archivar">

            <form id="formEditarProducto_$nombre" action="editarProducto.php" method="post">
                <input type="hidden" name="nombre" value="$nombre">
            </form>
            <i id="botonEditar"  class="fa-solid fa-pen-to-square" onclick="document.getElementById('formEditarProducto_$nombre').submit();"></i>

            </div>
            <form id="formBorrarProducto_$nombre" action="archivarProducto.php" method="post">
                <input type="hidden" name="nombre" value="$nombre">
            </form>
            <div>
            <button class="botonA" onclick="confirmarBorrado('$nombre')">ARCHIVAR</button>
            </div>

            <script>
            function confirmarBorrado(nombre) {
                if (confirm("¿Seguro que desea archivar este producto?")) {
                    document.getElementById('formBorrarProducto_' + nombre).submit();
                    alert("Se ha archivado con éxito: " + nombre );
                }
                else{
                    alert("Operación cancelada");
                }
            }
            </script>

            
        </div></div>


        EOS;
    } else if ($archivado == 0){
        // Botón para añadir al carrito
        $productos .= <<<EOS
                <form action="addProductoAlCarro.php" method="POST">
                <input type="hidden" name="id_producto" value="$id">
                <input type="number" name="unidades" min="1" max="$unidades" value="1">
                <button type="submit" class="botoncarro">Añadir al carrito</button>
                </form>
        </div>

        </div></div>
        EOS;
    }
                
    return $productos;
}
