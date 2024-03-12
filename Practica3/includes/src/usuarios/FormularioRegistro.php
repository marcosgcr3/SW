<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioRegistro extends Formulario
{
    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $NIF = $datos['NIF'] ?? '';

        $correo = $datos['correo'] ?? '';
        $nombre = $datos['nombre'] ?? '';
        $apellido = $datos['apellido'] ?? '';



        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['NIF', 'correo', 'password', 'password2'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <div class="container-registro">
            
                <label for="Nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                
                <label for="Apellido">Apellido:</label>
                <input id="apellido" type="text" name="apellido"  value="$apellido"/>
                
                <label for="NIF">NIF:</label>
                <input id="NIF" type="NIF" name="NIF" value="$NIF"/>
                {$erroresCampos['NIF']}
           
                <label for="Correo">Correo:</label>
                <input id="correo" type="email" name="correo" value="$correo"/>
                {$erroresCampos['correo']}
           
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" />
                {$erroresCampos['password']}
           
                <label for="password2">Reintroduce el password:</label>
                <input id="password2" type="password" name="password2" />
                {$erroresCampos['password2']}
            
                <button class="botonIni" type="submit" name="registro">Registrar</button>
            
        </div>
        EOF;
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $rol = "usuario";
        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $apellido = trim($datos['apellido'] ?? '');
        $apellido = filter_var($apellido, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
        //$apellido = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_SPECIAL_CHARS);
        $NIF = trim($datos['NIF'] ?? '');
        $NIF = ($NIF === '') ? null : filter_var($NIF, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $NIF || mb_strlen($NIF) < 9) {
            
            $this->errores['NIF'] = "El NIF tiene que tener una longitud de al menos 9 caracteres";
        }

        $correo = trim($datos['correo'] ?? '');
        $correo = ($correo === '') ? null : filter_var($correo, FILTER_VALIDATE_EMAIL);
        if (!$correo) {
            $this->errores['correo'] = "Introduce un correo válido";
        }

        $password = trim($datos['password'] ?? '');
        $password = ($password === '') ? null : filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$password || mb_strlen($password) < 5) {
            $this->errores['password'] = "La contraseña tiene que tener una longitud de al menos 5 caracteres";
        }

        $password2 = trim($datos['password2'] ?? '');
        $password2 = ($password2 === '') ? null : filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password2 || $password != $password2 ) {
            $this->errores['password2'] = 'Las contraseñas deben coincidir';
        }

        if (count($this->errores) === 0) {
            $usuario = Usuario::buscaPorNIF($NIF);
            if ($usuario) {
                $this->errores['NIF'] = "Este NIF ya está en uso";
            } else {
                $usuario = Usuario::buscaPorCorreo($correo);
                if ($usuario) {
                    $this->errores['correo'] = "Este email ya está en uso";
                } else {
                    $usuario =Usuario::crea($NIF, $nombre, $apellido, $correo, $password, $rol);
                    $usuario = Usuario::login($NIF, $password);
                    $app = Aplicacion::getInstance();
                    $app->login($usuario);
                }
        
            }
            
        }
    }
}