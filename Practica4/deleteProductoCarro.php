<?php


require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\productos\Producto;
use es\ucm\fdi\aw\pedidos\Pedidos;

$id_usuario =$_SESSION['id'];
$id_pedido = filter_input(INPUT_POST, 'id_pedido', FILTER_SANITIZE_SPECIAL_CHARS);
//$nombre_producto = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$unidades = filter_input(INPUT_POST, 'unidades', FILTER_SANITIZE_SPECIAL_CHARS);
$cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_SPECIAL_CHARS);
$id_producto = filter_input(INPUT_POST, 'producto', FILTER_SANITIZE_SPECIAL_CHARS);

$pedido = Pedidos::buscarCarrito($id_usuario);
$producto = Producto::buscaPorId($id_producto);

if($pedido == NULL){//si no existe el carrito
    echo "No existe el carrito";
}
else{//ya tiene carrito este usuario, lo compramos
    if(($cantidad - $unidades) == 0){
        $pedido->eliminarProducto($id_pedido,$id_producto);
    }
    else{
        $pedido->eliminarProductos($id_pedido,$id_producto, $unidades);
    }
    $producto->devolverProductos($id_producto, $unidades);  
    if(empty($pedido)){
        $pedido->borrarPedido_producto($pedido->getId_pedido());
        $pedido->borrarPedido($pedido->getId_pedido()); 
    }
}

header('Location: carro.php');
