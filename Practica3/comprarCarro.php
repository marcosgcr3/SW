<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\productos\producto;
use es\ucm\fdi\aw\pedidos\Pedidos;


$id_usuario =$_SESSION['id'];
$id_pedido = filter_input(INPUT_POST, 'id_pedido', FILTER_SANITIZE_SPECIAL_CHARS);
$precio_total = filter_input(INPUT_POST, 'precio_total', FILTER_SANITIZE_SPECIAL_CHARS);

    
    
$pedido = Pedidos::buscarCarrito($id_usuario); 
if($pedido == NULL){//si no existe el carrito
    echo "No existe el carrito en la base de datos";
}
else{//ya tiene carrito este usuario, lo compramos
    $pedido->finalizarPedido($pedido->getId_pedido());
    $pedido->insertaPrecioTotal($pedido->getId_pedido(), $precio_total);
    //bajar el numero de unidades de los productos del carro
    $productos = Producto::listaProductos($pedido->getId_pedido());
    foreach($productos as $producto){
        //NO ME LLEGA EL ID DEL PRODUCTO FALTA GRABE SI LO HAGO POR EL NOMBRE
        $id_aux = Producto::devolverId($producto->getNombre()); 
        $cantidad = Pedidos::cantidadDeProducto($pedido->getId_pedido(), $id_aux);
        $stock = Producto::buscaPorId($id_aux);
        $producto->setUnidades($stock->getUnidades() - $cantidad);
        $producto->guarda();
    }
    
}

//le llevo al index
header('Location: tienda.php');