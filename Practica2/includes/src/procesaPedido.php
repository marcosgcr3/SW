<?php

use Pedidos;

function procesaPedido()
{
    $carrito = Pedidos::buscarCarrito($_SESSION['idUsuario']);
    if (empty($carrito)) {
        return '<p>No hay articulos en el carrito</p>';
    }
    else{
        Pedidos::guarda($carrito[0]);
        $carrito->setEstado(TRUE);
    }
}