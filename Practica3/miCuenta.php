
<?php

require_once 'includes/config.php';

$tituloPagina = 'Mi cuenta';

$contenidoPrincipal=<<<EOS
        
<h1>Bienvenido {$_SESSION['id']} </h1>

<div class = "exit">

<a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>


</div> 
       
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);     
        

