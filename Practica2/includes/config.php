<?php
/* */
/* Parámetros de configuración de la aplicación */
/* */

// Parámetros de configuración generales

// Parámetros de configuración de la BD
define('RUTA_APP', '/SW/Practica2');
/* */
/* Utilidades básicas de la aplicación */
/* */

require_once __DIR__.'/src/Utils.php';

/* */
/* Inicialización de la aplicación */
/* */

/* */
/* Configuración de Codificación y timezone */
/* */



/* */
/* Clases y Traits de la aplicación */
/* */
//require_once 'src/Arrays.php';
require_once 'src/MagicProperties.php';

/* */
/* Clases que simulan una BD almacenando los datos en memoria */
/*
require_once 'src/usuarios/memoria/Usuario.php';
*/

/*
 * Configuramos e inicializamos la sesión para todas las peticiones
 */
session_start([
	'cookie_path' => RUTA_APP // Para evitar problemas si tenemos varias aplicaciones en htdocs
]);
/* */
/* Inicialización de las clases que simulan una BD en memoria */
/*
Usuario::init();
Mensaje::init();
*/

/* */
/* Clases que usan una BD para almacenar el estado */
/* */
require_once 'src/BD.php';
require_once 'src/Usuarios/Usuario.php';
//require_once 'src/mensajes/bd/Mensaje.php';