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

   

    if(Usuario::buscaPorNIF($NIF)){
        //$this->errores['NIF'] = "Este NIF de usuario ya está en uso";
    $htmlFormRegistro = buildFormularioRegistro($NIF, $nombre, $apellido, $correo, $password);
        $contenidoPrincipal=<<<EOS
		<h1>Error</h1>
		<p>El usuario o contraseña no son válidos.</p>
		$htmlFormRegistro
	EOS;
	require 'includes/design/comunes/layout.php';
	exit();
       
       

       
    }else{
        Usuario::crea($NIF, $nombre,$apellido,$correo, $password, $rol);
        
       
        
        $contenidoPrincipal=<<<EOS
        <h1>Usuario registrado correctamente</h1>
        
        EOS;
        require 'includes/design/comunes/layout.php';
        
    }

