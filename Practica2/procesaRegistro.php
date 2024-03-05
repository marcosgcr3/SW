<?php

require_once 'includes/config.php';
require_once 'includes/src/Usuarios/usuario.php';
require_once 'includes/acceso/autorizacion.php';
require_once 'includes/acceso/registro.php';

$tituloPagina = 'Registro';

$NIF = filter_input(INPUT_POST, 'NIF', FILTER_SANITIZE_SPECIAL_CHARS);
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$apellido = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_SPECIAL_CHARS);
$correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST["password"] ?? null;
$rol = "usuario";

    $usuario = (Usuario::buscaPorNIF($NIF));

    if($usuario){
        $this->errores['NIF'] = "Este NIF de usuario ya está en uso";
    } else {
        
        
        $usuario = Usuario::crea($NIF, $nombre,$apellido,$correo, $password, $rol);
        $app = BD::getInstance();

        $app->login($usuario);
        $contenidoPrincipal=<<<EOS
        <h1>Bienvenido {$_SESSION['nombre']}</h1>
        <p>Usa el menú de la izquierda para navegar.</p>
    EOS;
        require 'includes/design/comunes/layout.php';
    }

$contenidoPrincipal=<<<EOS
    <h1>Bienvenido {$_SESSION['nombre']}</h1>
	<p>Usa el menú de la izquierda para navegar.</p>
EOS;

require 'includes/design/comunes/layout.php';
