<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\alquilar\vehiculo;
require_once 'includes/config.php';
require_once 'includes/src/alquilar/listaAlquileres.php';



$tituloPagina = 'Mis Alquileres';

$contenidoPrincipal = '';


    $contenidoPrincipal .= <<<EOS
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script> 
    $(document).ready(function(){
      $("#alquileresActivos").click(function(){
        $("#lista1").slideToggle("slow", "linear");
      });
    });
    </script>
    <div id=alquileresActivos class="pedido">
    <h1>Alquileres Activos</h1>
    </div>
    <div id=lista1>
    EOS;
    $contenidoPrincipal .= listaAlquileres();
    $contenidoPrincipal .= <<<EOS
    </div>
    <script> 
    $(document).ready(function(){
      $("#alquileresPendientes").click(function(){
        $("#lista2").slideToggle("slow", "linear");
      });
    });
    </script>
    <div id=alquileresPendientes class="pedido">
    <h1 class="pedido">Alquileres Pendientes de Devolver</h1>
    </div>
    <div id=lista2>
    EOS;
    $contenidoPrincipal .= listaAlquileresPendientesDevolver();
    $contenidoPrincipal .= <<<EOS
    </div>
    <script> 
    $(document).ready(function(){
      $("#alquileresHistorial").click(function(){
        $("#lista3").slideToggle("slow", "linear");
      });
    });
    </script>
    <div id=alquileresHistorial class="pedido">
    <h1>Historial de Alquileres</h1>
    </div>
    <div id=lista3 class="productoPedido">
    EOS;
    $contenidoPrincipal .= listaHistorialAlquileres();
    $contenidoPrincipal .= listaHistorialCancelados();
    $contenidoPrincipal .=<<<EOS
    </div>
    <button class="botonC" onclick="location.href='miCuenta.php'">Volver</button>
    EOS;

    

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
