<?php

//use es\ucm\fdi\aw\clases\usuarios\FormularioVenta;
//use es\ucm\fdi\aw\clases\Item;

function mostrar_pedido()
{
    $html = listarPedido();  
    echo $html;
}
function listarPedido()
{
    $listaArticulos = Pedidos::listaPedidos($_SESSION['idUsuario']);
    if (empty($listaArticulos)) {
        return '<p>No hay articulos en tu pedido</p>';
    }

    $articulo = '';
    foreach ($listaArticulos as $articulo) {

        $articulos .= <<<EOS
        <div class="item">

            <div class="foto_articulo">
                <img src='./css/img/img_items/{$articulo->getNombre()}.png' alt='{$articulo->getNombre()}'/>
            </div>

            <div class="articulo">
                {$articulo->getNombre()}
            </div>

            <div class="vender_articulo">
                <button class="btn" onclick="window.location.href='ponerPrecio.php?item={$articulo->getNombre()}';">Vender</button>
            </div>

        </div>
        EOS;
    }

    $html = <<<EOS
    <div class="guia">
        <div>Foto</div>
        <div class = "div-opacidad">Nombre articulo</div>
        <div class = "div-opacidad">Venta</div>
    </div>
    <div class="lista_articulos">
        {$articulos}
    </div>
    EOS;

    return $html;
}
