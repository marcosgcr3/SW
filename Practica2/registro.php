<?php
require_once 'includes/config.php';
require_once 'includes/acceso/registro.php';


$tituloPagina = 'Login';

$htmlFormRegistro = buildFormularioRegistro();
$contenidoPrincipal=<<<EOS
<h1>Acceso al sistema</h1>
$htmlFormRegistro
EOS;

require 'includes/design/comunes/layout.php';