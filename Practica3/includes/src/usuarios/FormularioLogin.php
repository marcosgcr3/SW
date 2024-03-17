<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioLogin extends Formulario
{
    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $NIF = $datos['NIF'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['NIF', 'password'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <div class="container-registro">
            
          
            <p>NIF:</p>
            <input id="NIF" type="text" name="NIF" value="$NIF" />
            {$erroresCampos['NIF']}
        
            <p>Contraseña:</p>
            <input id="password" type="password" name="password" />
            {$erroresCampos['password']}
           
            <div>
                <button class="botonIni" type="submit" name="login">Entrar</button>
            </div>
        </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $NIF = trim($datos['NIF'] ?? '');
        $NIF = filter_var($NIF, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $NIF || empty($NIF) ) {
            $this->errores['NIF'] = 'El NIF no puede estar vacío';
        }
        
        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || empty($password) ) {
            $this->errores['password'] = 'El password no puede estar vacío.';
        }
        
        if (count($this->errores) === 0) {
            $usuario = Usuario::login($NIF, $password);
            
            if (!$usuario) {
                $this->errores[] = "El NIF o la contraseña no coinciden";
            } else {
                
                $app = Aplicacion::getInstance();
                $app->login($usuario);
            }
        }
    }
}
