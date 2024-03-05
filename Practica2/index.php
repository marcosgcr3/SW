<?php

require_once 'includes/config.php';


$tituloPagina = 'Portada';
if( esMecanico() ){
    $contenidoPrincipal=<<<EOS
    <h1>Bienvenido mecanico {$_SESSION['nombre']}</h1>
    EOS;
    require 'includes/design/comunes/layout.php';
    exit();
}else if(esAdmin()){
    $contenidoPrincipal=<<<EOS
    <h1>Bienvenido admin {$_SESSION['nombre']}</h1>
    EOS;
    require 'includes/design/comunes/layout.php';
    exit();
}else{
$contenidoPrincipal=<<<EOS
<h1>Página principal</h1> 
<div class="imagen">
<img src="img/foto_mecanico.jpg" id="imagenPrincipal" alt="centrado">
</div>
<p> 
    Los mejores artículos para tu coche al mejor precio del mercado.
    Podrás ser recomendado por nuestros increibles mecánicos expertos en mantenimieto
    y acondicionamiento de automóviles. Además, estos podrán repara tu vehículo, 
    realizarle algunas mejoras técnicas o hacerle la revisión de la ITV. También puedes disponer 
    de un servicio de alquiler de automóviles en caso de no disponer de uno o simplemente 
    poder conducir el coche que siempre deseaste. No lo dudes y confía en DRIVECRAFTERS.
</p>
<button class="botonIni" onclick="location.href='entrar.php'">LOGIN/REGISTER</button>
EOS;

require 'includes/design/comunes/layout.php';


}
