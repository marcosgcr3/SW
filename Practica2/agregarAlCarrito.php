<?php

require_once 'includes/config.php';
require_once 'includes/src/Pedidos/Pedidos.php';

$id_usuario = $_SESSION['id'];
$nombre = filter_input(INPUT_GET, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$unidades = filter_input(INPUT_GET, 'unidades', FILTER_SANITIZE_SPECIAL_CHARS);

$carrito = Pedidos::crea($id_usuario, FALSE, 0);

$carrito->anyadirProducto($nombre, $unidades, $carrito);
header('Location: tienda.php');