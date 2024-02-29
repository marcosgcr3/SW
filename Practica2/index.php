<?php

require_once 'includes/config.php';

$tituloPagina = 'Portada';

$contenidoPrincipal=<<<EOS
<h1>Página principal</h1> 
<div class="imagen">
<img src="img/foto1.jpg" id="imagenPrincipal" alt="centrado">
</div>
<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

require 'includes/componentes/layout.php';