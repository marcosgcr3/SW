<?php

use Pedidos;

function mostrar_pedido()
{
    $html = listarPedido();  
    echo $html;
}

function mostrar_carrito()
{
    $html = listarPedido();  
    echo $html;
}

function listarPedido() {

    $listaPedidos = Pedidos::listaPedidos($_SESSION['idUsuario']);
    if (empty($listaArticulos)) {
        return '<p>No hay pedidos anteriores</p>';
    }

    $pedidos = '';
    $productos = '';
    foreach ($listaPedidos as $pedido) {

        $pedidos .= 
        '<div class="id_pedido">
            {$pedido->getId()}
        </div>';
       

        $listaProductos = $pedido->getProductos();

        foreach($listaProductos as $producto){
            
            $productos .= <<<EOS
            <div class="infoProducto">

                <div class="fotoProducto">
                    <img src='./img/img_productos/{$producto->getNombre()}.png' alt='{$producto->getNombre()}'/>
                </div>

                <div class="articulo">
                    {$producto->getNombre()}
                </div>

                <div class="precio">
                    {$producto->getPrecio()}
                </div>

            </div>
            EOS;

        }

        $precioTotal .=
        '<div class="precioTotal">
            // Precio Total 
        </div>';
    }


    $html = <<<EOS
    <div class="guia">
        <div>Pedido
        <div>Foto</div>
        <div>Nombre producto</div>
        <div>Precio producto</div>
        </div>
    </div>
    <div class="listaPedidos">
        {$pedidos}
        <div class="listaProductos">
        {$productos}
        </div>
    </div>
    EOS;

    return $html;
}

function listarCarrito()
{
    $carrito = Pedidos::buscarCarrito($_SESSION['idUsuario']);
    if (empty($carrito)) {
        return '<p>No hay articulos en el carrito</p>';
    }

    $productos = '';
    $listaProductos = $carrito[0]->getProductos();
    foreach ($listaProductos as $producto) {

        $productos .= <<<EOS
        <div class="infoProducto">

            <div class="fotoProducto">
                <img src='./css/img/img_items/{$producto->getNombre()}.png' alt='{$producto->getNombre()}'/>
            </div>

            <div class="producto">
                {$producto->getNombre()}
            </div>

            <div class="precio">
                {$producto->getPrecio()}
            </div>

        </div>
        EOS;
    }

    $precioTotal .= <<<EOS
    <div class="precioTotal">
        // Precio Total 
    </div>


    $html = <<<EOS
    <div class="guia">
        <div>Foto</div>
        <div>Nombre Producto</div>
        <div>Precio Producto</div>
    </div>
    <div class="listaProductos">
        {$productos}
    </div>
    EOS;

    return $html;
}
