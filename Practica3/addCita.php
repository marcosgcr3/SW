<?php

require_once __DIR__.'/includes/config.php';

$formCita = new es\ucm\fdi\aw\citas\FormularioCita();
$formCita =$formCita->gestiona();


$tituloPagina = 'Cita';
$contenidoPrincipal=<<<EOF
  	<h1>Pedir Cita</h1>
      $formCita
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);