<?php

require_once __DIR__.'/includes/config.php';
$id_usuario = $_SESSION['id'];
$matricula = filter_input(INPUT_GET, 'matricula', FILTER_SANITIZE_SPECIAL_CHARS);

$formAlquiler = new \es\ucm\fdi\aw\alquilar\FormularioAlquiler($id_usuario, $matricula);
$formAlquiler = $formAlquiler->gestiona();


$tituloPagina = 'Alquiler de vehiculo';
$contenidoPrincipal=<<<EOF
  	<h1>Alquilando</h1>
    $formAlquiler
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);