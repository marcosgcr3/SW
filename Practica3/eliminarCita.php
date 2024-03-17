<?php

use es\ucm\fdi\aw\citas\Citas;
use es\ucm\fdi\aw\vehiculos\Vehiculo;

require_once __DIR__.'/includes/config.php';






$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
Citas::borrar($id);
header('Location: misCitas.php');
