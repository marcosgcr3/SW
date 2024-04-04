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
    else{                   //Historial de pedidos del usuario
        $pedidos = Pedidos::listaPedidos($id_user);  //Devuelve la lista de los pedidos del user
        //Hacer un foreach llamando a la funcion de productos que me devuelve la lista de los productos y luego otro foreach para sacar la lista
        mostrarPedidos($pedidos);

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
    foreach($pedidos as $pedido){
        $aux = Producto::listaProductos($pedido->getId_pedido());
        $html = listarPedido($aux, null);
        return $html;
    }

}

function listarPedido($carrito, $id_pedido)
{
    if(empty($carrito)){
        return '<p>El carrito esta vacio</p>';
    }
    else{
        $productos = '';
        $precio_total = '';
        foreach($carrito as $producto){
            $nombre = $producto->getNombre();
            $cantidad = $producto->getUnidades();
            $precio = $producto->getPrecio();
            $precio2 = $precio*$cantidad;
            $imagen = $producto->getImagen();
            

            $productos .= <<<EOS
            <div class="producto">

            <div class="fotoProducto">
                <img src="$imagen" alt="imagen" class="producto-imagen">
            </div>

            <div class="nombreProducto">
                {$nombre}
            </div>
            
            <div class="cantidad">
                {$cantidad}
            </div>

            <div class="precio"> <!-- Aqui el precio del producto -->
                <p>Precio por unidad:</p>
                {$precio} €
            </div>

            <div class="precio2">
                <p>Precio total:</p>
                {$precio2} €
            </div>

            </div>
            EOS;
        }

        $id_usuario = $_SESSION['id'];
        $precio_total .= Pedidos::calculaPrecioTotal($id_pedido);
        $productos .= <<<EOS
            <div class="precioCarritoTotal">
                <p>TOTAL:</p>
                {$precio_total} € <!-- Aqui el precio total del carrito -->
            <form action="comprarCarro.php" method="post">
                <input type="hidden" name="id_usuario" value="{$id_usuario}">
                <input type="hidden" name="id_pedido" value="{$id_pedido}">
                <input type="hidden" name="precio_total" value="{$precio_total}">
                <button type="submit">Comprar</button>
            </form>
           
            </div>
        EOS;

    }
    return $productos;
}
