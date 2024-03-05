<?php

require_once 'includes/config.php';
require_once 'includes/src/Usuarios/usuario.php';
require_once 'includes/acceso/autorizacion.php';
require_once 'includes/acceso/login.php';

$tituloPagina = 'Login';

$NIF = filter_input(INPUT_POST, 'NIF', FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST["password"] ?? null;

$esValido = $NIF && $password && ($usuario = Usuario::login($NIF, $password));
if (!$esValido) {
	
	$contenidoPrincipal=<<<EOS
		<h1>Error</h1>
		<p>El usuario o contraseña no son válidos.</p>
		$htmlFormLogin
	EOS;
	require 'includes/design/comunes/layout.php';
	exit();
}


$_SESSION['NIF'] = $usuario->NIF;

$_SESSION['rol'] = $usuario->rol;
$_SESSION['nombre'] = $usuario;
    
$contenidoPrincipal=<<<EOS
    <h1>Bienvenido {$_SESSION['nombre']}</h1>
	<p>Usa el menú de la izquierda para navegar.</p>
EOS;

require 'includes/design/comunes/layout.php';




