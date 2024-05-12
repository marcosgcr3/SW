
<?php

require_once 'includes/config.php';




$formContacto = new \es\ucm\fdi\aw\contacto\FormularioContacto();

$formContacto = $formContacto->gestiona();


$tituloPagina = 'Contacto';
$contenidoPrincipal=<<<EOF
  	<h1>Contactar</h1>
    $formContacto
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);