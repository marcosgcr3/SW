<?php

require_once __DIR__.'/includes/config.php';


$formVehiculo =new es\ucm\fdi\aw\vehiculos\FormularioVehiculo();
$formVehiculo =$formVehiculo->gestiona();


$tituloPagina = 'Registro';
$contenidoPrincipal=<<<EOF
  	<h1>Registro de Producto</h1>
      $formVehiculo
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);