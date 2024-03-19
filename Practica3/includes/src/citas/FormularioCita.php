<?php

namespace es\ucm\fdi\aw\citas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\citas\Citas;
require_once 'procesaHorarioDisp.php';

class FormularioCita extends Formulario{
    public function __construct() {
        parent::__construct('formCita', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/citas.php')]);
    }


    protected function generaCamposFormulario(&$datos){
        $dia = $datos['dia'] ?? '';
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
        if (isset($_POST['dia'])) {
            $elDia = $_POST['dia'];
            echo "<p>El dia es: $elDia</p>";
        }
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
            $cita = new Citas($_SESSION['id'], $_SESSION['id_mecanico'], $dia, $hora, $asunto);
            
        }
    }
           
    

}