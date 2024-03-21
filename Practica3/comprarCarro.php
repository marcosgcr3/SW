<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\productos\Producto;
use es\ucm\fdi\aw\pedidos\Pedidos;


//filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$id_usuario =$_SESSION['id'];
$id_pedido = filter_input(INPUT_POST, 'id_pedido', FILTER_SANITIZE_SPECIAL_CHARS);
//$id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_SANITIZE_SPECIAL_CHARS);
//$id_producto = $_POST['id_producto'];
    
    
$pedido = Pedidos::buscarCarrito($id_usuario); 
if($pedido == NULL){//si no existe el carrito
    echo "No existe el carrito en la base de datos";
}
else{//ya tiene carrito este usuario, lo compramos
    $pedido->finalizarPedido($pedido->getId_pedido());
}


//le llevo al index
header('Location: index.php');