<?php 

//Hay que implementar clases articuloTienda y una para el formulario de la compra
//Tambien hay que hacer el objeto articulo para poder mostrarlos bien en la tienda
require_once 'includes/config.php';
require_once 'includes/vistas/plantillas/alquiler.php';
use es\ucm\fdi\aw\alquilar\alquilar;
$contenido = '';
function listaAlquileresPendientesDevolver(){
    $alquileres = Alquilar::alquileresPendientesDeDevolver($_SESSION['id']);
    $contenido = '';
    if (empty($alquileres)) {
        return sinAlquiler();
    }

    foreach ($alquileres as $alquiler) {
        $contenido .= vehiculoPendiente($alquiler);
    }

    return $contenido;

}
function listaAlquileres()
{
    
    $alquileres = Alquilar::listaAlquileres($_SESSION['id']);
    $contenido = '';
    if (empty($alquileres)) {
        return sinAlquiler();
    }

    foreach ($alquileres as $alquiler) {
        $contenido .= elVehiculoAlquilado($alquiler);
    }

    return $contenido;
}
function listaHistorialAlquileres()
{
        
        $alquileres = Alquilar::historialAlquileres($_SESSION['id']);
        $contenido = '';
        if (empty($alquileres)) {
            return sinAlquiler();
        }
    
        foreach ($alquileres as $alquiler) {
            $contenido .= elVehiculoAlquilado($alquiler);
        }
    
        return $contenido;
}
function elVehiculoAlquilado($alquiler){
   $contenido = buildAlquiler($alquiler);
   return $contenido;
}
function vehiculoPendiente($alquiler){
    $contenido = buildAlquilerPendiente($alquiler);
    return $contenido;
}

function sinAlquiler(){
    $contenido = "<tr><td colspan='4'>No hay alquileres</td></tr>";
    return $contenido;
}

