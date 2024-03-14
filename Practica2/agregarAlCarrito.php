<?php

require_once 'includes/config.php';
require_once 'includes/src/Pedidos/Pedidos.php';
use es\ucm\fdi\aw\BD;

$id_usuario = $_SESSION['id'];
$nombre = $_POST["nombre"] ?? null;
$unidades = $_POST["unidades"] ?? null;

//si no tiene un carrito, se lo creamos
$carrito = Pedidos::buscarCarrito(2);
if($carrito == NULL){
    $carrito = Pedidos::crea(2, FALSE, 0);
}


$carrito -> anyadirProducto("6", '1', "1");
$carrito -> eliminarProducto("6", '1', "1");
