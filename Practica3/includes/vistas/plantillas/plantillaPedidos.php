<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\pedidos\Pedidos;
use es\ucm\fdi\aw\productos\producto;

function buildPedido($id_user,$estado)
{
    if($estado === TRUE){   //Carrito
        $id_carro = Pedidos::buscarCarrito($id_user); //Devuelve el id del pedido
        if($id_carro === NULL){
            $contenido = '<p>El carrito esta vacio</p>';
        }
        else{
            $carrito = Producto::listaProductos($id_carro->getId_pedido());
            //Llamar a producto para que me devuelva la lista de los articulos
            $contenido = mostrarCarrito($carrito);
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

function mostrarCarrito($carrito)
{
    $html = listarPedido($carrito);
    echo $html;
}

function mostrarPedidos($pedidos)
{
    foreach($pedidos as $pedido){
        $aux = Producto::listaProductos($pedido->getId_pedido());
        $html = listarPedido($aux);
        echo $html;
    }

}

function listarPedido($carrito)
{
    if(empty($carrito)){
        return '<p>El carrito esta vacio</p>';
    }
    else{
        $productos = '';
        foreach($carrito as $producto){
            $nombre = $producto->getNombre();
            $cantidad = $producto->getUnidades();
            $precio = $producto->getPrecio();
            $precio2 = $precio*$cantidad;
            $imagen = $producto->getImagen();

            $productos .= <<<EOS
            <div class="producto">

            <div class="fotoProducto">
                <img src='./img/imgProductos/{$imagen}.png' />
            </div>

            <div class="nombreProducto">
                {$nombre}
            </div>
            
            <div class="cantidad">
                {$cantidad}
            </div>

            <div class="precio">
                {$precio} 
            </div>

            <div class="precio2">
                {$precio2}
            </div>

            </div>
            EOS;
        }

        $productos .= <<<EOS
            <div class="precioCarritoTotal">
            {$carrito->getPrecioTotal()}
            </div>
        EOS;
        
    }
    
}
