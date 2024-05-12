<?php


require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\productos\producto;
use es\ucm\fdi\aw\pedidos\Pedidos;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($app->usuarioLogueado()){
        $id_usuario =$_SESSION['id'];
        $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_SANITIZE_SPECIAL_CHARS);
        $unidades = filter_input(INPUT_POST, 'unidades', FILTER_SANITIZE_SPECIAL_CHARS);
        //$id_producto = $_POST['id_producto'];
        //$unidades = $_POST['unidades'];
    
        $pedido = Pedidos::buscarCarrito($id_usuario);
        $producto = producto::buscaPorId($id_producto);

        if($pedido == NULL){//si no existe el carrito, lo creo
            $pedido = Pedidos::crea($id_usuario, 0, 0);
            $pedido->anyadirProducto($pedido->getId_pedido(),$id_producto, $unidades);
        }
        else{//ya tiene carrito este usuario, añado el producto al carrito

            $pedido->anyadirProducto($pedido->getId_pedido(),$id_producto, $unidades);
        }
        $producto->borrarProductos($id_producto, $unidades);
        header('Location: tienda.php');
    } else{
        header('Location: noUsuarioAviso.php');
    }

}  
