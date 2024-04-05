<?php

require_once __DIR__.'/includes/config.php';


use es\ucm\fdi\aw\alquilar\Alquilar;



$tituloPagina = 'Devolver vehiculo';
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
Alquilar::cambiarEstado($id);
header('Location: misAlquileres.php');