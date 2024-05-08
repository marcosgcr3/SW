<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\alquilar\alquilar;
use es\ucm\fdi\aw\vehiculos\vehiculo;
require_once 'includes/config.php';
require_once 'includes/src/vehiculos/listado_vehiculos.php';

require_once 'includes/src/vehiculos/vehiculo.php';

function barraFiltros(){

$contenidoPrincipal = '';

$contenidoPrincipal .= <<<EOS

<meta charset="utf-8">
<div class="barra">
  <h2 class="filtros">Filtros</h3>
  <form method="post" action="veremos">
    <input type="text" name="nombreV"/>
    <button class="buscar" type="submit"><i class="fa fa-search"></i> </button>
  </form>  
  <h3 class="fabricante" href="#">Fabricante</h3>
  <select name="coches" id="filtrosC">
    <option value="nada">Cualquiera</option>
EOS;

$marcas = vehiculo::listaMarcas();
foreach($marcas as $marca){
    $contenidoPrincipal .= <<<EOS
    <option value="{$marca}">{$marca}</option>
    EOS;
}

$contenidoPrincipal.=<<<EOS
  </select>
  <h3 class="rango" href="#">Rango de precio</h3>
  <form method="post" action="veremos">
    <label for="min"> Precio minimo: </label>
    <input type="text" id="min" name="min"/>
    <br><br>
    <label for="max"> Precio maximo: </label>
    <input type="text" id="max"  name="max"/>
    <br><br>
    <button class="buscar" type="submit"><i class="fa fa-search"></i> </button>
  </form>  
  <h3 class="anyo" href="#">Año de fabricacion</h3>
  <select name="anyo" id="filtrosA">
    <option value="0">Cualquiera</option>
EOS;
    $anyos = vehiculo::listaAnyos();
    foreach($anyos as $anyo){
        $contenidoPrincipal .= <<<EOS
        <option value="{$anyo}">{$anyo}</option>
    EOS;
}
$contenidoPrincipal .= <<<EOS
  </select>
</div>
EOS;

return $contenidoPrincipal;

}