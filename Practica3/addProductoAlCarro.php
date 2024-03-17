<?php




require_once __DIR__.'/includes/config.php';




$formPedidos = new \es\ucm\fdi\aw\pedidos\FormularioPedido();

$formPedidos = $formPedidos->gestiona();




//volver a la tienda.php

header('Location: tienda.php');