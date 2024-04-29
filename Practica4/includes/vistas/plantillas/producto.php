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
    } else if ($archivado == 0){
        // Botón para añadir al carrito
        $productos .= <<<EOS
                <form action="addProductoAlCarro.php" method="POST">
                <input type="hidden" name="id_producto" value="$id_producto">
                <input type="number" name="unidades" min="1" max="$unidades" value="1">
                <button type="submit" class="botoncarro">Añadir al carrito</button>
            </form>
        </div>

        </div></div></div>
        EOS;

        $productos .= <<<EOS
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            //Coloca aquí el fragmento de código JavaScript para validar el formulario y enviar datos con AJAX -->
            $(document).ready(function() {
                //Manejar el evento de envío del formulario -->
                $("#form[action='addProductoAlCarro.php']").submit(function(event) {
                    //Obtener el valor de unidades seleccionado -->
                    var unidades = $(this).find("input[name='unidades']").val();
                    
                    //Si no se ha seleccionado ninguna unidad, mostrar un mensaje de alerta -->
                    if (unidades <= 0) {
                        alert("Por favor, seleccione al menos una unidad del producto.");
                        return;
                    }
                    
                    //Obtener los datos del formulario -->
                    var formData = $(this).serialize();
                    
                    //Enviar los datos utilizando AJAX -->
                    $.ajax({
                        type: "POST",
                        url: $(this).attr("action"),
                        data: formData,
                        success: function(response) {
                            //Manejar la respuesta del servidor aquí -->
                            alert(response); // Solo para propósitos de demostración, puedes hacer lo que desees con la respuesta
                        },
                        error: function(xhr, status, error) {
                            //Manejar errores de AJAX aquí -->
                            console.error(error);
                        }
                    });
                });
            });            
        </script>
        EOS;
    }
                
    return $productos;
}
