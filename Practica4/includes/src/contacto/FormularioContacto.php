<?php

namespace es\ucm\fdi\aw\contacto;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioContacto extends Formulario {

    public function __construct() {
        parent::__construct('formContacto', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('tienda.php')]);
    }

    protected function generaCamposFormulario(&$datos) {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'email', 'comentario'], $this->errores, 'span', ['class' => 'error']);

        $nombre = $datos['nombre'] ?? '';
        $email = $datos['email'] ?? '';
        $mensaje = $datos['comentario'] ?? '';

        

        $html = <<<EOF
        $htmlErroresGlobales
        <div class="Informacion personal">
            <fieldset>  
                <legend>Información personal</legend>
                <div class="name">
                    <label for="name">Nombre:</label>
                    <input type="text" name="nombre" id="name" size="30" placeholder="Ingresa tu nombre" class="campo" autocomplete="off" required value="$nombre" />
                    {$erroresCampos['nombre']}
                </div>
                <div class="email">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" size="40" placeholder="Ingresa tu correo electrónico" class="campo" autocomplete="off" required value="$email" />
                    {$erroresCampos['email']}
                </div>
            </fieldset>
            <fieldset>
                <legend>Motivo de la consulta</legend>
                <div class="Evaluacion">
                    <input type="radio" name="motivo" id="evaluacion" value="Evaluacion" checked />
                    <label for="evaluacion">Evaluación</label>
                </div>
                <div class="Sugerencias">
                    <input type="radio" name="motivo" id="sugerencias" value="Sugerencias" />
                    <label for="sugerencias">Sugerencias</label>
                </div>
                <div class="Criticas">
                    <input type="radio" name="motivo" id="critica" value="Criticas" />
                    <label for="critica">Crítica</label>
                </div>
                <div class="textbox">
                    <textarea id="consultaBox" name="comentario" rows="15" cols="80" placeholder="Ingresa tu consulta" autocomplete="off" required>$mensaje</textarea>
                    {$erroresCampos['comentario']}
                </div>
                <div class="checkbox">
                    <input id="mycheckbox" type="checkbox" name="Terminos y conndiciones" value="on" autocomplete="off" required />
                    <label for="mycheckbox">Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio</label>
                </div>
            </fieldset>
            <button class="button" id="myButton" type="submit" name="submit" value="Enviar form.">Enviar</button>
        </div>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $nombre = $datos['nombre'] ?? '';
        if (empty($nombre)) {
            $this->errores['nombre'] = 'El nombre no puede estar vacío';
        }

        $email = $datos['email'] ?? '';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errores['email'] = 'Introduce un correo electrónico válido';
        }

        $mensaje = $datos['comentario'] ?? '';
        if (empty($mensaje)) {
            $this->errores['comentario'] = 'El mensaje no puede estar vacío';
        }
        $asunto = $datos['motivo'];

       
        if (count($this->errores) === 0) {
            $destinatario = 'drivecrafters@ucm.es';
            $titulo = "Nuevo mensaje de contacto: $asunto";
            $mensajeCorreo = "Nombre: $nombre\n\n";
            $mensajeCorreo .= "Email: $email\n\n";
            $mensajeCorreo .= "Mensaje:\n$mensaje";

            // Envío del correo
            
            $enviado = mail($destinatario, $titulo, $mensajeCorreo);

            if (!$enviado) {
                $this->errores['envio'] = 'Error al enviar el mensaje. Por favor, inténtelo de nuevo más tarde.';
            }
        }
    }
}
