<?php

use es\ucm\fdi\aw\alquilar\alquilar;
use es\ucm\fdi\aw\vehiculos\vehiculo;

require_once __DIR__.'/includes/config.php';






$id = filter_input(INPUT_POST, 'id_alquiler', FILTER_SANITIZE_SPECIAL_CHARS);
Alquilar::borrar($id);
header('Location: misAlquileres.php');


