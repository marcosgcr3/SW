<?php 


require_once 'includes/config.php';
require_once 'includes/vistas/plantillas/vehiculo.php';
use es\ucm\fdi\aw\vehiculos\vehiculo;

function listavehiculos()
{
    $vehiculos = Vehiculo::listaVehiculos();
    $contenido = '';
    if (empty($vehiculos)) {
        return sinVehiculo();
    }

    foreach ($vehiculos as $vehiculo) {
        $contenido .= elVehiculo($vehiculo);
    }

    return $contenido;
}

function elVehiculo($vehiculo){
   $contenido = buildVehiculo($vehiculo);
   return $contenido;
}

function sinVehiculo(){
    $contenido = "<tr><td colspan='4'>No hay vehiculos disponibles</td></tr>";
    return $contenido;
}

function añadirVehiculo(){
    $contenido = <<<EOS
    <button class="botonIni" onclick="location.href='addVehiculo.php'">Añadir Vehiculo</button>
    EOS;
    return $contenido;
}
