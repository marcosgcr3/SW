<?php

namespace es\ucm\fdi\aw\citas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\eventos\Evento;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\citas\citas;
use \DateTime;

use es\ucm\fdi\aw\usuarios\Usuario;
require_once 'procesaHorarioDisp.php';

class FormularioCita extends Formulario{

    public function __construct() {
        parent::__construct('formCita', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('misCitas.php')]);
    }


    protected function generaCamposFormulario(&$datos){
        date_default_timezone_set("Europe/Madrid");
        $dia = $datos['dia'] ?? '';
        //$dia = '2024-04-18';
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
                
                {$erroresCampos['hora']}


        </div>

        EOF;
        $horasDisp = horarioDisponible($dia);
        foreach ($horasDisp as $hora) {
            $html .= "<option value='$hora'>$hora:00</option>";
        } 


        $html .= <<<EOF
            </select>
            {$erroresCampos['hora']}
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
        else if(strtotime($dia) < strtotime(date('Y-m-d'))){
            $this->errores['dia'] = "El día no puede ser anterior a la fecha de hoy";
        }
        $hora = $datos['hora'] ?? null;

        if (empty($hora)) {
            $this->errores['hora'] = "La hora no puede estar vacía";
        }
        $startDate = $dia . ' ' . $hora . ':00:00';

        $endDate = date('Y-m-d H:i:s', strtotime($startDate) + 3600);

        $asunto = $datos['asunto'] ?? null;
        if (empty($asunto)) {
            $this->errores['asunto'] = "El asunto no puede estar vacío";
        }
        
        if (count($this->errores) === 0) {
            $mecanico = Usuario::obtenerMecanicoDisponible($dia, $hora);
            if($mecanico === NULL){
                echo '<script>
                    displayMessage()
                </script> ';
            }
            else{
                $startDate = new DateTime($startDate);
                $endDate = new DateTime($endDate);
                Evento::creaDetallado($_SESSION['id'], $mecanico->getId(), $asunto, $startDate, $endDate, 0);
                
            }            
        }
    }
           
    

}