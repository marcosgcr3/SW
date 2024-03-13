<?php 

//Hay que implementar clases articuloTienda y una para el formulario de la compra
//Tambien hay que hacer el objeto articulo para poder mostrarlos bien en la tienda
require_once 'includes/config.php';
require_once 'includes/vistas/plantillas/citas.php';

$contenido = '';

function misCitas($row){
   $contenido = buildCita($row['id_cita'],$row['dia'], $row['hora'],$row['asunto']);
   return $contenido;
}

function sinCitas(){
    $contenido = <<<EOS
    <h2>No tienes citas</h2>
    <button class="botonIni" onclick="location.href='addCita.php'">Agendar Cita</button>
    EOS;
    return $contenido;
}

function newCita(){
    $contenido = <<<EOS
    <button class="botonIni" onclick="location.href='addCita.php'">Agendar Cita</button>
    EOS;
    return $contenido;
}
