<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\productos\producto;
use es\ucm\fdi\aw\pedidos\Pedidos;


function buildArticulo($producto)
{
    $productos = '';
    
    $id = $producto->getId();
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
            <form id="formBorrarProducto_$nombre" action="borrarProducto.php" method="post">
                <input type="hidden" name="nombre" value="$nombre">
            </form></div>
            <i id="iconoBasura" class="fa-solid fa-trash" onclick="document.getElementById('formBorrarProducto_$nombre').submit();"></i>

            <form id="formEditarProducto_$nombre" action="editarProducto.php" method="post">
                <input type="hidden" name="nombre" value="$nombre">
            </form></div>
            <i id="iconoEditar"  onclick="document.getElementById('formEditarProducto_$nombre').submit();">EDITAR</i>
        </div></div>
        EOS;
    } else if ($archivado == 0){
        // Botón para añadir al carrito
        $productos .= <<<EOS
                <form action="addProductoAlCarro.php" method="POST" id="formAddProducto">
                <input type="hidden" name="id_producto" id="idProducto" value="$id_producto">
                <input type="hidden" name="nombre" id="nombre" value="$nombre">
                <input type="number" name="unidades" id="units" min="1" max="100000" value="1">
                <button type="submit" id="bottonCompra" class="botoncarro">Añadir al carrito</button>
                </form>
        </div>

        </div></div></div>
        EOS;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    $productos .= <<<EOS
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            
            $(document).ready(function() {
                //VALIDAR FORMULARIO DE bottonCompra (añadir al carrito)
                $('[id^="formAddProducto"]').submit(function(event) {
                    var unidades = $(this).find('[name="unidades"]').val();
                    var idProducto = $(this).find('[name="id_producto"]').val();
                    var nombre = $(this).find('[name="nombre"]').val();
                    var stock = $unidades;
                    if (unidades > stock) {
                        alert('No hay suficiente stock');
                        event.preventDefault();
                    }
                    else{
                        alert('Se ha añadido al carro ' + unidades + ' ' + nombre);
                        //solo tiene que ejecutarse una vez
                        $(this).unbind('submit').submit();

                    }
                    
                });
            });            
        </script>
        EOS;
                
    return $productos;
}
