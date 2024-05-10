<?php 


require_once 'includes/config.php';
require_once 'includes/vistas/plantillas/vehiculo.php';
use es\ucm\fdi\aw\vehiculos\vehiculo;

function listavehiculos()
{
    $vehiculos = Vehiculo::listaVehiculosDisponibles();
    $contenido = '';
    if (empty($vehiculos)) {
        return sinVehiculo();
    }

    foreach ($vehiculos as $vehiculo) {
        $contenido .= elVehiculo($vehiculo);
    }

    return $contenido;
}

function listavehiculosPorMarca($marca)
{
    $vehiculos = Vehiculo::listaVehiculosMarca($marca);
    $contenido = '';
    if (empty($vehiculos)) {
        return sinVehiculo();
    }

    foreach ($vehiculos as $vehiculo) {
        $contenido .= elVehiculo($vehiculo);
    }

    return $contenido;
}

function listavehiculosPorAnyo($anyo)
{
    $vehiculos = Vehiculo::listavehiculosPorAnyo($anyo);
    $contenido = '';
    if (empty($vehiculos)) {
        return sinVehiculo();
    }

    foreach ($vehiculos as $vehiculo) {
        $contenido .= elVehiculo($vehiculo);
    }

    return $contenido;
}

function listavehiculosPorPrecio($min, $max)
{
    $vehiculos = Vehiculo::listavehiculosPorPrecio($min, $max);
    $contenido = '';
    if (empty($vehiculos)) {
        return sinVehiculo();
    }

    foreach ($vehiculos as $vehiculo) {
        $contenido .= elVehiculo($vehiculo);
    }

    return $contenido;
}
function listavehiculosPorPA($min, $max, $anyo)
{
    $vehiculos = Vehiculo::listavehiculosPorPA($min, $max,$anyo);
    $contenido = '';
    if (empty($vehiculos)) {
        return sinVehiculo();
    }

    foreach ($vehiculos as $vehiculo) {
        $contenido .= elVehiculo($vehiculo);
    }

    return $contenido;
}
function listavehiculosPorPM($min, $max, $request)
{
    $vehiculos = Vehiculo::listavehiculosPorPM($min, $max, $request);
    $contenido = '';
    if (empty($vehiculos)) {
        return sinVehiculo();
    }

    foreach ($vehiculos as $vehiculo) {
        $contenido .= elVehiculo($vehiculo);
    }

    return $contenido;
}
function listavehiculosPorMA($request, $anyo)
{
    $vehiculos = Vehiculo::listavehiculosPorMA($request, $anyo);
    $contenido = '';
    if (empty($vehiculos)) {
        return sinVehiculo();
    }

    foreach ($vehiculos as $vehiculo) {
        $contenido .= elVehiculo($vehiculo);
    }

    return $contenido;
}
function listavehiculosFiltrados($request, $min, $max, $anyo)
{
    $vehiculos = Vehiculo::listavehiculosFiltrados($request, $min, $max, $anyo);
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
    $contenido = <<<EOS
    <div class="producto">
    <h3>No hay vehículos disponibles</h3>
    </div>
    EOS;
    return $contenido;
}

function añadirVehiculo(){
    $contenido = <<<EOS
    <button class="botonIni" onclick="location.href='addVehiculo.php'">Añadir Vehiculo</button>
    EOS;
    return $contenido;
}
