<?php
require_once __DIR__.'/includes/config.php';
$tituloPagina = "Calendario";
$ev = filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
use es\ucm\fdi\aw\usuarios\Usuario;

$contenidoPrincipal = '';

if($app->esAdmin()){
  
  $mecanicos = Usuario::listaMecanicos();

  $contenidoPrincipal = '';

  $idMecanico = ''; // Inicializar la variable

  if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['mecanico'])) {
      $idMecanico = $_GET['mecanico']; // Guardar el ID del mecánico seleccionado
  }

  $contenidoPrincipal = '';

  $contenidoPrincipal .= <<<HTML
  <form id="formSeleccionMecanico" action="{$_SERVER['PHP_SELF']}" method="get">
      <input type="hidden" name="accion" value="seleccionar_mecanico">
      <select class="selectMecanico" name="mecanico">
          <option value="-">-</option>';
  HTML;

  foreach($mecanicos as $mecanico){
      $selected = ($idMecanico == $mecanico->getId()) ? 'selected' : ''; // Marcar como seleccionado si es el mecánico actual
      $contenidoPrincipal .= '<option value="' . $mecanico->getId() . '" ' . $selected . '>' . $mecanico->getNombre() . '</option>';
  }

  $contenidoPrincipal .= <<<HTML
      </select>
      <button class ="botonSeleccionarMecanico" type="submit">Seleccionar</button>
  </form>
  HTML;
  $ev = 'eventosAdmin.php?idMecanico=' . $idMecanico;
}

/*if($app->esCliente()){
  $ev = 'misCitas.php';
}*/



$contenidoPrincipal  .= <<<HTML

  <div class="container">
    <div id="calendar"></div>
  </div>


HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'tipo' => $ev];
$app->generaVista('/plantillas/plantilla.php', $params);
