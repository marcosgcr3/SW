<?php

require_once 'includes/config.php';

$tituloPagina = 'entrar';

$contenidoPrincipal=<<<EOS
<div class = "Entrar">
            
    <h2><a href="login.php">INICIAR SESION</a></h2>
    <h2><a href="registro.php">NO TENGO CUENTA</a></h2>
</div>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
