<?php
use es\ucm\fdi\aw\vehiculos\Vehiculo;


require_once __DIR__.'/includes/config.php';

require_once 'includes/src/vehiculos/vehiculo.php';



$matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_SPECIAL_CHARS);




Vehiculo::borrar($matricula);
header('Location: alquiler.php');


