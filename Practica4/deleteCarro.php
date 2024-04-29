<?php


require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\productos\Producto;
use es\ucm\fdi\aw\pedidos\Pedidos;

$id_usuario =$_SESSION['id'];
$id_pedido = filter_input(INPUT_POST, 'id_pedido', FILTER_SANITIZE_SPECIAL_CHARS);

$pedido = Pedidos::buscarCarrito($id_usuario);

if($pedido == NULL){//si no existe el carrito
    echo "No existe el carrito";
}
else{//ya tiene carrito este usuario, lo compramos
    $pedido->borrarPedido_producto($pedido->getId_pedido());
    $pedido->borrarPedido($pedido->getId_pedido());    
}

//le llevo al index
header('Location: carro.php');
