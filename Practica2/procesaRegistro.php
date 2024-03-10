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
$password2 = $_POST["password2"] ?? null;
$rol = "usuario";
$contenidoPrincipal = "";
$errores = array();

$NIF = ($NIF === '') ? null : filter_var($NIF, FILTER_VALIDATE_INT);
if ( ! $NIF || mb_strlen($NIF) < 9) {
    $errores['NIF'] = "El NIF tiene que tener una longitud de al menos 9 caracteres";
}
$correo = ($correo === '') ? null : filter_var($correo, FILTER_VALIDATE_EMAIL);
if (!$correo) {
    $errores['correo'] = "Introduce un correo válido";
}

$password = ($password === '') ? null : filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (!$password || mb_strlen($password) < 5) {
    $errores['password'] = "La contraseña tiene que tener una longitud de al menos 5 caracteres";
}

$password2 = ($password2 === '') ? null : filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($password != $password2) {
    $errores['password2'] = "Los passwords deben coincidir";
}

if (count($errores) == 0) {
    $usuario = Usuario::buscaPorNIF($NIF);

    if ($usuario) {
        $errores['NIF'] = "Este NIF ya está en uso";
    } else {
        $usuario = Usuario::buscaPorCorreo($correo);
        if ($usuario) {
            $errores['correo'] = "Este email ya está en uso";
        } else {
            Usuario::crea($NIF, $nombre, $apellido, $correo, $password, $rol);
            $contenidoPrincipal .= "<h1>Usuario registrado correctamente</h1>";
        }

    }
    if (count($errores) != 0){
        foreach ($errores as $error) {
            $contenidoPrincipal .= "<p>$error</p>";
        }
        $htmlFormRegistro = buildFormularioRegistro($nombre, $apellido, $correo,$NIF, $password, $password2);
        $contenidoPrincipal .= $htmlFormRegistro;
    }
    

} else {
    foreach ($errores as $error) {
        $contenidoPrincipal .= "<p>$error</p>";
    }
    $htmlFormRegistro = buildFormularioRegistro($nombre, $apellido, $correo,$NIF, $password, $password2);
    $contenidoPrincipal .= $htmlFormRegistro;
}



require 'includes/design/comunes/layout.php';

