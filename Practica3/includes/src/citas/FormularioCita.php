<?php

namespace es\ucm\fdi\aw\citas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\citas\Citas;

class FormularioCita extends Formulario{

    public function __construct() {
        parent::__construct('formCita', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/misCitas.php')]);
    }


    protected function generaCamposFormulario(&$datos){
        $dia = $datos['dia'] ?? '';
        $dia = '2024-03-21';
        $hora = $datos['hora'] ?? '';
        $asunto = $datos['asunto'] ?? '';
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['dia', 'hora', 'asunto'], $this->errores, 'span', array('class' => 'error'));
        $html = <<<EOF
        $htmlErroresGlobales
        
        <div class="container-registro">
                <label for="Asunto">Asunto:</label>
                <input id="asunto" type="text" name="asunto" value="$asunto" />
                {$erroresCampos['asunto']}

                <label for="Dia">Dia:</label>
                <input id="dia" type="date" name="dia" value="$dia" />
                {$erroresCampos['dia']}
                
                <label for='Hora'>Horario:</label>
                <select id='hora' name='hora'>
                <option value=''>Seleccione una hora</option>
                


        </div>

        EOF;
        $horasDisp = horarioDisponible($dia);
        foreach ($horasDisp as $hora) {
            $html .= "<option value='$hora'>$hora:00</option>";
        }
        $html .= "</select>";

        $html .= <<<EOF
            <button class="botonIni" type="submit" name="registro">Registrar</button>
        EOF;

        return $html;
    }protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $dia = $datos['dia'] ?? null;
        if (empty($dia)) {
            $this->errores['dia'] = "El dia no puede estar vacío";
        }
        $hora = $datos['hora'] ?? null;
        if (empty($hora)) {
            $this->errores['hora'] = "La hora no puede estar vacía";
        }
        $asunto = $datos['asunto'] ?? null;
        if (empty($asunto)) {
            $this->errores['asunto'] = "El asunto no puede estar vacío";
        }
        if (count($this->errores) === 0) {
            Citas::crea($_SESSION['id'], '3', $dia, $hora, $asunto);
            
        }
    }
           
    

}