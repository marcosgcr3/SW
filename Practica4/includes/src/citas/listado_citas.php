<?php 

//Hay que implementar clases articuloTienda y una para el formulario de la compra
//Tambien hay que hacer el objeto articulo para poder mostrarlos bien en la tienda
require_once 'includes/config.php';
require_once 'includes/vistas/plantillas/citas.php';

use es\ucm\fdi\aw\citas\citas;

$contenido = '';

function listaCitas(){
    $citas = Citas::listaCitas();
    $contenido = '';
    if(empty($citas)){
        return sinCitas();
    }
    foreach ($citas as $cita){
            $contenido .= misCitas($cita);
    }
    return $contenido;
}
function listaCitasHistorial(){
    $citas = Citas::listaCitasHistorial($_SESSION['id']);
    $contenido = '';
    if(empty($citas)){
        return sinCitas();
    }
    foreach ($citas as $cita){
        if($cita->getEstado()==1)
            $contenido .= misCitas($cita);
    }
    return $contenido;
}
function listaCitasMecanico($id){
    $citas = Citas::listaCitasM($id);
    $contenido = '';
    if(empty($citas)){
        return sinCitas();
    }
    
    foreach ($citas as $cita){
        $contenido .= misCitas($cita);
    }
    $contenido .= <<<EOS
    <button class="botonIni" onclick="location.href='addCita.php'">Agendar Cita</button>
    EOS;
    return $contenido;
}
function listaCitasMecanicoDias($id){
    $dias = Citas::diasConCitas($id);
    $contenido = '';
    foreach ($dias as $dia){
        $contenido .= "<h2>$dia</h2>";
        $citas = Citas::listaCitasMecanicoEnUnDia($id, $dia);
        foreach ($citas as $cita){
            $contenido .= misCitas($cita);
        }
       
    }
    return $contenido;

}

function misCitas($cita){
   $contenido = buildCita($cita);
   return $contenido;
}
function misCitasH($cita){
    $contenido = buildCitaH($cita);
    return $contenido;
 }
function sinCitas(){
    $contenido = <<<EOS
    <h2>No tienes citas</h2>
    EOS;
    return $contenido;
}

function newCita(){
    $contenido = <<<EOS
    <button class="botonIni" onclick="location.href='addCita.php'">Agendar Cita</button>
    EOS;
    return $contenido;
}