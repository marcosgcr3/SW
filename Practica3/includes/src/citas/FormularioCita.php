<?php

namespace es\ucm\fdi\aw\citas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;






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
                
                
        
        </div>
        EOF;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT hora FROM Citas WHERE id_cliente = {$_SESSION['id']} AND dia = '$dia'";
        $result = $conn->query($sql);
        if (!$result->num_rows > 0){

            $html .= "<div class='container-registro'>";
            $html .= "<label for='Hora'>Hora:</label>";
            $html .= "<select id='hora' name='hora'>";
            $html .= "<option value=''>Selecciona una hora</option>";
            while ($row = $result->fetch_assoc()) {
                $html .= "<option value='{$row['hora']}'>{$row['hora']}</option>";
            }
            $html .= "</select>";
            $html .= "{$erroresCampos['hora']}";
            $html .= "</div>";

        }

        return $html;
    }protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $dia = $datos['dia'] ?? null;
        if ( empty($dia) ) {
            $this->errores['dia'] = "El dia no puede estar vacío";
        }
        $hora = $datos['hora'] ?? null;
        if ( empty($hora) ) {
            $this->errores['hora'] = "La hora no puede estar vacía";
        }
    
    }
           


}