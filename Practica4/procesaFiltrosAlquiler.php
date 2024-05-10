<?php

require_once 'includes/config.php';

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\vehiculos\vehiculo;

require_once 'includes/src/vehiculos/listado_vehiculos.php';


$marca = filter_input(INPUT_GET,'marca', FILTER_SANITIZE_STRING, 1);
$min = filter_input(INPUT_GET,'min', FILTER_VALIDATE_INT, 1);
$max = filter_input(INPUT_GET,'max', FILTER_VALIDATE_INT, 1);
$anyo = filter_input(INPUT_GET,'anyo', FILTER_VALIDATE_INT, 1);


$html = '';

if ($marca === 'nada' and empty($min) and empty($max) and $anyo === 0) {

    Vehiculo::comprobarDisponibilidadTodos();
    // Alquilar::comprobarFecha();
    $html .= "<div class = prueba>";
    $html .= listavehiculos();
    $html .= "</div>";


    if( $app->esAdmin() ){
        $html.= añadirVehiculo();
    }
} else {
    Vehiculo::comprobarDisponibilidadTodos();
    // Alquilar::comprobarFecha();
    if($marca === 'nada' and empty($min) and empty($max) and $anyo !== 0){ //Por año
        $html .= "<div class = prueba>";
        $html .= listavehiculosPorAnyo($anyo);
        $html .= "</div>";
    }
    elseif($marca !== 'nada' and empty($min) and empty($max) and $anyo === 0){    //Por marca
        $html .= "<div class = prueba>";
        $html .= listavehiculosPorMarca($marca);
        $html .= "</div>";
    }
    elseif($marca === 'nada' and (!empty($min) or !empty($max)) and $anyo === 0){   //Por precio
        $html .= "<div class = prueba>";
        $html .= listavehiculosPorPrecio($min, $max);
        $html .= "</div>";
    }
    elseif($marca === 'nada' and (!empty($min) or !empty($max)) and $anyo > 0){   //Por precio y año
        $html .= "<div class = prueba>";
        $html .= listavehiculosPorPA($min, $max, $anyo);
        $html .= "</div>";
    }
    elseif($marca !== 'nada' and (!empty($min) or !empty($max)) and $anyo === 0){   //Por precio y marca
        $html .= "<div class = prueba>";
        $html .= listavehiculosPorPM($min, $max, $marca);
        $html .= "</div>";
    }
    elseif($marca !== 'nada' and empty($min) and empty($max) and $anyo !== 0 and $anyo > 0){   //Por marca y año

        $html .= "<div class = prueba>";
        $html .= listavehiculosPorMA($marca, $anyo);
        $html .= "</div>";
    }
    else{
        $html .= "<div class = prueba>";
        $html .= listavehiculosFiltrados($marca, $min, $max, $anyo);
        $html .= "</div>";
    }

    if( $app->esAdmin() ){
        $html.= añadirVehiculo();
    }
}

echo $html;

