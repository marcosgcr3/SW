<?php

require_once __DIR__.'/includes/config.php';

$matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_SPECIAL_CHARS);
$formVehiculoEditor =new es\ucm\fdi\aw\vehiculos\FormularioEditor($matricula);
$formVehiculoEditor =$formVehiculoEditor->gestiona();


$tituloPagina = 'Editar';
$contenidoPrincipal=<<<EOF
  	<h1>Editor de Vehiculo</h1>
      $formVehiculoEditor
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);