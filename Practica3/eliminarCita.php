<?php

use es\ucm\fdi\aw\citas\citas;

require_once __DIR__.'/includes/config.php';






$id = filter_input(INPUT_POST, 'id_cita', FILTER_SANITIZE_SPECIAL_CHARS);
//Citas::borrar($id);
$cita = Citas::buscaPorId($id);
Citas::cambiarEstado($cita);
header('Location: misCitas.php');
