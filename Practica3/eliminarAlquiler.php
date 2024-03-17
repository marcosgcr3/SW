<?php

use es\ucm\fdi\aw\alquilar\Alquilar;
use es\ucm\fdi\aw\vehiculos\Vehiculo;

require_once __DIR__.'/includes/config.php';






$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$alquiler = Alquilar::buscaPorIdAlquiler($id);
$vehiculo = Vehiculo::buscaPorId($alquiler->getIdVehiculo());
Alquilar::borrar($id);
Vehiculo::cambiarDisponibilidad($vehiculo);
header('Location: misAlquileres.php');


