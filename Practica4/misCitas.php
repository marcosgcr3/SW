<?php

use es\ucm\fdi\aw\Aplicacion;

require_once 'includes/config.php';
require_once 'includes/src/citas/listado_citas.php';
require_once 'includes/src/citas/horarioMecanico.php';
require_once 'includes/src/productos/producto.php';
require_once 'procesaHorarioDisp.php';

$tituloPagina = 'Mis Citas';

$contenidoPrincipal = '';

$contenidoPrincipal .= <<<EOS
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script> 
    $(document).ready(function(){
      $("#citasActivas").click(function(){
        $("#lista1").slideToggle("slow", "linear");
      });
    });
    </script>
<div id=citasActivas class="pedido">
<h1>Citas Activas</h1>
</div>
<div id=lista1>
EOS;
$contenidoPrincipal .= listaCitas();
$contenidoPrincipal .= <<<EOS
</div>
<script> 
$(document).ready(function(){
  $("#citasHistorial").click(function(){
    $("#lista2").slideToggle("slow", "linear");
  });
});
</script>
<div id=citasHistorial class="pedido">
<h1>Historial de Citas</h1>    
</div>
<div id=lista2 class="productoPedido">
EOS;
$contenidoPrincipal .= listaCitasHistorial();
$contenidoPrincipal .= '</div>';
$contenidoPrincipal .= newCita();
$contenidoPrincipal .=<<<EOS
<button class="botonC" onclick="location.href='miCuenta.php'">Volver</button>
EOS;;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
