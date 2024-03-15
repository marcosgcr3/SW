<?php

require_once 'includes/config.php';
require_once 'includes/src/Pedidos/pedidos.php';
$tituloPagina = 'contacto';
$id_usuario = $_SESSION['id'];

$pedido = Pedidos::buscarCarrito($id_usuario);

     $contenidoCarro =$pedido.mostrar_carrito();


    $contenidoPrincipal= '';
   
    $contenidoPrincipal.=$contenidoCarro;
    
  


    

    require 'includes/design/comunes/layout.php';