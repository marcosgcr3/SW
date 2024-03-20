<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\Usuario;
require_once 'includes/config.php';
require_once 'includes/src/citas/listado_citas.php';
$tituloPagina = 'Gestionar citas';

// Función para listar las citas del mecánico seleccionado


// Si se ha enviado el formulario con el ID del mecánico seleccionado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["accion"]) && $_POST["accion"] == "seleccionar_mecanico") {
    // Obtener el ID del mecánico seleccionado
    $idMecanico = $_POST["mecanico"];
    // Llamar a la función listaCitasMecanico con el ID del mecánico
    
}

// Obtener la lista de mecánicos
$mecanicos = Usuario::listaMecanicos();

// Construir el desplegable con los nombres de los mecánicos
$selectMecanicos = '<select name="mecanico">';
foreach($mecanicos as $mecanico){
    $selectMecanicos .= '<option value="' . $mecanico->getId() . '">' . $mecanico->getNombre() . '</option>';
}
$selectMecanicos .= '</select>';

// Formulario oculto para enviar los datos mediante POST
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
