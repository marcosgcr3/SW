<?php

require_once __DIR__.'/includes/config.php';

$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$formEditarProducto = new es\ucm\fdi\aw\productos\FormularioEditarProducto($nombre);
$formEditarProducto =$formEditarProducto->gestiona();


$tituloPagina = 'Registro';
$contenidoPrincipal=<<<EOF
  	<h1>Registro de Producto</h1>
      $formEditarProducto
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);