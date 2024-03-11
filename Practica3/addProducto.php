<?php

require_once __DIR__.'/includes/config.php';

$formProducto = new es\ucm\fdi\aw\productos\FormularioProducto();
$formProducto =$formProducto->gestiona();


$tituloPagina = 'Registro';
$contenidoPrincipal=<<<EOF
  	<h1>Registro de Producto</h1>
      $formProducto
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);