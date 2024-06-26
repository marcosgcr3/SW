<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\pedidos\Pedidos;
use es\ucm\fdi\aw\productos\producto;

function buildPedido($id_user,$estado)
{
    if($estado === FALSE){   //Carrito
        $id_carro = Pedidos::buscarCarrito($id_user); //Devuelve el id del pedido
        if($id_carro === NULL){
            $contenido = '<p>El carrito esta vacio</p>';
        }
        else{
            $carrito = Producto::listaProductos($id_carro->getId_pedido());
            //Llamar a producto para que me devuelva la lista de los articulos
            $contenido = mostrarCarrito($carrito, $id_carro->getId_pedido());//$carrito array y carrito id
        }
    }
    else{ //Historial de pedidos del usuario
        $pedidos = Pedidos::listaPedidos($id_user);  //Devuelve la lista de los pedidos del user
        //Hacer un foreach llamando a la funcion de productos que me devuelve la lista de los productos y luego otro foreach para sacar la lista
        $contenido = mostrarPedidos($pedidos);

    }   
    $app = Aplicacion::getInstance();
    if ($app->esAdmin()) {
        //$contenido .='</div><i id="iconoBasura" class="fa-solid fa-trash" onclick="location.href=\'borrarVehiculo.php?matricula=' . $matricula . '\';"></i></div></div>';
    } else {
        
    }

    return $contenido;
}

function mostrarCarrito($carrito, $id_pedido)
{
    $html = listarPedido($carrito, $id_pedido);//$carrito array y carrito id
    return $html;
}

function mostrarPedidos($pedidos)
{
    $productos = '';
    $cont = 1;
    foreach($pedidos as $pedido){//por cada pedido
        $aux = Producto::listaProductos($pedido->getId_pedido());
        $productos .= <<<EOS
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script> 
        $(document).ready(function(){
          $("#pedido{$cont}").click(function(){
            $("#panel{$cont}").slideToggle("slow", "linear");
          });
        });
        </script>

        <div id=pedido{$cont} class="pedido">
            <h2>Pedido {$cont}</h2>
        </div>
        <div id=panel{$cont} class="productoPedido">
        EOS;
        $precio_total = '';
        foreach($aux as $producto){//por cada producto del pedido
            $nombre = $producto->getNombre();
            $cantidad = $producto->getUnidades();
            $precio = $producto->getPrecio();
            $precio2 = $precio*$cantidad;
            $imagen = $producto->getImagen();
            $productos .= <<<EOS
                <div class="productoX">
                <div class="producto-info">
                    <img src="$imagen" alt="imagen" class="producto-imagen">
                    <div class="producto-detalle">
                        <h2>{$nombre}</h2>
                        <p>Numero de productos: {$cantidad} </p>
                        <p>Precio por unidad : {$precio} € </p>
                        <p>Precio total de este articulo: {$precio2} €</p>
                    </div>  
                </div>
            </div>
            EOS;
        }
        $cont = $cont + 1;
        $precio_total .= Pedidos::calculaPrecioTotal($pedido->getId_pedido());
        $productos .= <<<EOS
            <div class="precioCarritoTotal">
                <p>TOTAL: {$precio_total} € <!-- Aqui el precio total de ese pedido --></p>
            </div>
            <hr/>
            </div>
            </div>
        EOS;

        //$html = listarPedido($aux, null);
        //return $html;
    }
    return $productos;
}


function listarPedido($carrito, $id_pedido)
{
    if(empty($carrito)){
        return '<p>El carrito esta vacio</p>';
    }
    else{
        $id_usuario = $_SESSION['id'];
        $productos = '';
        $precio_total = '';
        foreach($carrito as $producto){
            $nombre = $producto->getNombre();
            $cantidad = $producto->getUnidades();
            $precio = $producto->getPrecio();
            $precio2 = $precio*$cantidad;
            $imagen = $producto->getImagen();
            $id_producto = $producto->getId();
            

            $productos .= <<<EOS
            <div class="productoX">
                <div class="producto-info">
                    <img src="$imagen" alt="imagen" class="producto-imagen">
                    <div class="producto-detalle">
                        <h2>{$nombre}</h2>
                        <p>Numero de productos: {$cantidad} </p>
                        <p>Precio por unidad : {$precio} € </p>
                        <p>Precio total :{$precio2} €</p>
                        <form action="deleteProductoCarro.php" method="post">
                            <input type="hidden" name="id_usuario" value="{$id_usuario}">
                            <input type="hidden" name="producto" value="{$id_producto}">
                            <input type="hidden" name="id_pedido" value="{$id_pedido}">
                            <input type="hidden" name="cantidad" value="{$cantidad}">
                            <h4>Eliminar: <input type="number" name="unidades" min="1" max="$cantidad" value="1"> <button class="botonCa" type="submit">Eliminar seleccionado</button></h4>
                        </form>
                    </div>  
                </div>
            </div>
            EOS;
        }

        $precio_total .= Pedidos::calculaPrecioTotal($id_pedido);
        $productos .= <<<EOS
            <div class="precioCarritoTotal">
                <p>TOTAL:  {$precio_total} € <!-- Aqui el precio total del carrito --></p>
            <form id="compraCarro" action="comprarCarro.php" method="post">
                <input type="hidden" name="id_usuario" value="{$id_usuario}">
                <input type="hidden" name="id_pedido" value="{$id_pedido}">
                <input type="hidden" name="precio_total" value="{$precio_total}">
                
            </form>
            <button class="botoncarro" onclick="confirmarCompra()">Comprar</button>
            <script>
            function confirmarCompra() {
                if (confirm("¿Seguro que desea realizar la compra?")) {
                    document.getElementById('compraCarro').submit();
                    alert("Se ha realizado la compra con éxito");
                } else {
                    alert("Operación cancelada");
                }
            }
        </script>


            <form id="deleteCarro" action="deleteCarro.php" method="post">
            <input type="hidden" name="id_usuario" value="{$id_usuario}">
            <input type="hidden" name="id_pedido" value="{$id_pedido}">
        </form>
        <button class="botonCa" onclick="confirmarBorrado()">Eliminar carrito</button>
        <script>
            function confirmarBorrado() {
                if (confirm("¿Seguro que desea eliminar el carrito?")) {
                    document.getElementById('deleteCarro').submit();
                    alert("Se ha eliminado con éxito");
                } else {
                    alert("Operación cancelada");
                }
            }
        </script>
        

            </div>
        EOS;
    }
    return $productos;
}
