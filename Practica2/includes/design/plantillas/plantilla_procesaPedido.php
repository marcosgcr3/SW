<?php
require_once 'includes/config.php';

    $tituloPagina = 'Procesando pedido';


    $contenidoPrincipal= '';
    $contenidoCarro = mostrar_carrito();
    $contenidoPrincipal.='' . $contenidoCarro . '';
    require 'includes/design/comunes/layout.php';

