
<?php

use es\ucm\fdi\aw\Aplicacion;
require_once 'includes/config.php';

$tituloPagina = 'Mi cuenta';




$contenidoPrincipal=<<<EOS
        
<h1>Bienvenido {$_SESSION['id']} </h1>

<div class = "exit">

<a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
<button class="botonIni" onclick="location.href='misAlquileres.php'">Mis Alquileres</button>
<button class="botonIni" onclick="location.href='misCitas.php'">Mis Citas</button>




</div> 
       
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);     
        

