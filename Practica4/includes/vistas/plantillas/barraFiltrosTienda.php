<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\productos\Producto;
require_once 'includes/config.php';
require_once 'includes/src/vehiculos/listado_vehiculos.php';

require_once 'includes/src/vehiculos/vehiculo.php';

function barraFiltros(){

$html = '';

$html .=<<<EOS

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="barra">
  <h2 class="filtros">Filtros</h3>
  <h3 class="rango" href="#">Rango de precio</h3>
    <label for="min"> Precio minimo: </label>
        <input type="text" id="min" name="min"/>
        <br><br>
        <label for="max"> Precio maximo: </label>
        <input type="text" id="max"  name="max"/>
        <br><br>
    <button class="buscar" id="filtrosP"><i class="fa fa-search"></i> </button>
  <h3 class="categoria" href="#">Categoria de producto</a>
  <select name="categorias" id="filtrosCat">
    <option value="nada">Cualquiera</option>
EOS;

$categorias = Producto::listaCategorias();
foreach($categorias as $categoria){
  $html .= <<<EOS
  <option value="{$categoria}">{$categoria}</option>
  EOS;
}
$html .=<<<EOS
</select>
</div>
<div class=prueba>
EOS;

return $html;

}