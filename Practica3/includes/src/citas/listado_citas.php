<?php 

//Hay que implementar clases articuloTienda y una para el formulario de la compra
//Tambien hay que hacer el objeto articulo para poder mostrarlos bien en la tienda
require_once 'includes/config.php';
require_once 'includes/vistas/plantillas/citas.php';
use es\ucm\fdi\aw\citas\Citas;

$contenido = '';

function listaCitas(){
    $citas = Citas::listaCitas($_SESSION['id']);
    $contenido = '';
    if(empty($citas)){
        return sinCitas();
    }
    
    foreach ($citas as $cita){
        $contenido .= misCitas($cita);
    }
    return $contenido;
}

function misCitas($cita){
   $contenido = buildCita($cita);
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
