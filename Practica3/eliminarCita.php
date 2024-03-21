<?php

use es\ucm\fdi\aw\citas\Citas;

require_once __DIR__.'/includes/config.php';






$id = filter_input(INPUT_POST, 'id_cita', FILTER_SANITIZE_SPECIAL_CHARS);
Citas::borrar($id);
header('Location: misCitas.php');
