<?php

use es\ucm\fdi\aw\alquilar\Alquilar;
use es\ucm\fdi\aw\vehiculos\Vehiculo;

require_once __DIR__.'/includes/config.php';






$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

Alquilar::borrar($id);
header('Location: misAlquileres.php');


