<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\Usuario;
require_once 'includes/config.php';

$tituloPagina = 'Gestionar citas';

$mecanicos = Usuario::listaMecanicos();

// Construir el desplegable con los nombres de los mecánicos
$selectMecanicos = '<select name="mecanico">';
foreach($mecanicos as $mecanico){
    $selectMecanicos .= '<option value="' . $mecanico->getId() . '">' . $mecanico->getNombre() . '</option>';
}
$selectMecanicos .= '</select>';

$contenidoPrincipal = <<<EOS
<div class="mecanico">
    <h2>Selecciona un mecánico:</h2>
    $selectMecanicos
</div>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);     
