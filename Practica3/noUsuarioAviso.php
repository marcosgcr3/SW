<?php

require_once 'includes/config.php';

$tituloPagina = 'No registrado';

$contenidoPrincipal=<<<EOS
<div class="noRegistrado">
            <h1>LO SIENTO DEBES HABER INICIADO SESION 
                    PARA ACCEDER A ESTE APARTADO</h1>
        </div>
        <div class="noRegistrado">
            
          <img src="img/NOO.png" id="noUser" alt="centrado">

            
        </div>
        <button class="botonIni" onclick="location.href='entrar.php'">LOGIN/REGISTER</button>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);




