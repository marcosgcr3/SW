
<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';


$tituloPagina = 'Mi cuenta';




$contenidoPrincipal =<<<EOS
        
<h1>Bienvenido {$_SESSION['rol']}, {$_SESSION['nombre']} </h1>

<div class = "exit">
</div> 
       
EOS;

if($app->esCliente()){
    $contenidoPrincipal .=<<<EOS
    <button class="botonIni" onclick="location.href='misAlquileres.php'">Mis Alquileres</button>
    <button class="botonIni" onclick="location.href='misCitas.php'">Mis Citas</button>
    <button class="botonIni" onclick="location.href='misPedidos.php'">Mis Pedidos</button>
    <button class="botonC" onclick="location.href='logout.php'">Cerrar sesion</button>
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a> 
    EOS;
}
else{
    $contenidoPrincipal .=<<<EOS
    <button class="botonC" onclick="location.href='logout.php'">Cerrar sesion</button>
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
    EOS;
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);     
        

