<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\Usuario;
require_once 'includes/config.php';
require_once 'includes/src/citas/listado_citas.php';
$tituloPagina = 'Gestionar citas';


$idMecanico = filter_input(INPUT_POST, 'mecanico', FILTER_SANITIZE_SPECIAL_CHARS);


$mecanicos = Usuario::listaMecanicos();


$selectMecanicos = '<select name="mecanico">';
$selectMecanicos .= '<option value="-">-</option>'; 
foreach($mecanicos as $mecanico){
    $selectMecanicos .= '<option value="' . $mecanico->getId() . '">' . $mecanico->getNombre() . '</option>';
}
$selectMecanicos .= '</select>';


$formulario = <<<HTML
<form id="formSeleccionMecanico" action="{$_SERVER['PHP_SELF']}" method="post">
    <input type="hidden" name="accion" value="seleccionar_mecanico">
    $selectMecanicos
    <button type="submit">Seleccionar</button>
</form>
HTML;

$contenidoPrincipal = <<<EOS
<div class="mecanico">
    <h2>Selecciona un mecánico:</h2>
    $formulario
</div>

EOS;
$contenidoPrincipal .= listaCitasMecanico($idMecanico);
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
