
<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/pedidos/listadoPedidos.php';
require_once 'includes/src/productos/producto.php';


$tituloPagina = 'Mi cuenta';




$contenidoPrincipal=<<<EOS
        
<h1>Bienvenido {$_SESSION['rol']}, {$_SESSION['id']} </h1>

<div class = "exit">

<a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
<button class="botonIni" onclick="location.href='misAlquileres.php'">Mis Alquileres</button>
<button class="botonIni" onclick="location.href='misCitas.php'">Mis Citas</button>

<h1>Historial de Pedidos</h1>


</div> 
       
EOS;

if($app->esCliente()){
    $contenidoPrincipal .= pedido();
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);     
        

