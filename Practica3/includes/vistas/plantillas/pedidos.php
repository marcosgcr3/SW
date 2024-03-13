<?php

require_once 'includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Pedido;

function buildPedido0($id_user,$estado)
{
    if($estado === TRUE){   //Carrito
        $carrito = Pedido::buscarPorEstado($id_user,$estado);
        $contenido = mostrarCarrito($carrito);
    }
    else{                   //Historial de pedidos del usuario
        $pedidos = Pedido::buscarPorUser($id_user);
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
    $html = listaCarrito($carrito);
    echo $html;
}

function mostrarPedidos($pedidos)
{
    $html = listaPedidos($pedidos);
    echo $html;
}

function listaCarrito($carrito)
{
    if(empty($carrito)){
        return '<p>El carrito esta vacio</p>';
    }
    else{
        $productos = '';
        foreach($carrito as $producto){
            $nombre = $getNombre();
            $cantidad = $getCantidad();
            $precio = $getPrecio();
            $precio2 = $precio*$cantidad;

            $productos .= <<<EOS
            <div class="producto">

            <div class="fotoProducto">
                <img src='./img/imgProductos/{$nombre}.png' />
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

function listaPedidos($pedidos)
{
