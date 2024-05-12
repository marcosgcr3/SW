<?php


require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\productos\producto;
use es\ucm\fdi\aw\pedidos\Pedidos;

$id_usuario =$_SESSION['id'];
$id_pedido = filter_input(INPUT_POST, 'id_pedido', FILTER_SANITIZE_SPECIAL_CHARS);

$pedido = Pedidos::buscarCarrito($id_usuario);
$carrito = producto::listaProductos($pedido->getId_pedido());

if($pedido == NULL){//si no existe el carrito
    echo "No existe el carrito";
}
else{//ya tiene carrito este usuario, lo compramos
    foreach($carrito as $productoC){
        $producto = producto::buscaPorId($productoC->getId());
        $producto->devolverProductos($producto->getId(), $productoC->getUnidades());
    }
    $pedido->borrarPedido_producto($pedido->getId_pedido());
    $pedido->borrarPedido($pedido->getId_pedido());    
}

//le llevo al index
header('Location: carro.php');
