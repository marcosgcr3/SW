<?php 

//Hay que implementar clases articuloTienda y una para el formulario de la compra
//Tambien hay que hacer el objeto articulo para poder mostrarlos bien en la tienda
require_once 'includes/config.php';
require_once 'includes/vistas/plantillas/plantillaPedidos.php';

$contenido = '';

function pedido(){
   $contenido = buildPedido($_SESSION['id'], TRUE);
   return $contenido;
}

function carrito(){
    $contenido = buildPedido($_SESSION['id'], FALSE);
    return $contenido;
 }
