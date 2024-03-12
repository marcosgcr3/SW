<?php

namespace es\ucm\fdi\aw\alquilar;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\vehiculos\Vehiculo;

class FormularioAlquiler extends Formulario{
    private $id_usuario;
    private $matricula;
    private $id_vehiculo;
    private $vehiculo;

    public function __construct($id_usuario, $matricula) {
        parent::__construct('formAlquiler', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/alquiler.php')]);
        $this->id_usuario = $id_usuario;
        $this->matricula = $matricula;
        $this->vehiculo = \es\ucm\fdi\aw\vehiculos\Vehiculo::buscaPorMatricula($matricula);
        $this->id_vehiculo = $this->vehiculo->getId();
    }
    

    protected function generaCamposFormulario(&$datos){
        $fechaIni = $datos['fechaIni'] ?? '';
        $fechaFin = $datos['fechaFin'] ?? '';
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['fechaIni', 'fechaFin'], $this->errores, 'span', array('class' => 'error'));
        
        $html = <<<EOF
        $htmlErroresGlobales
        <div class="container-registro">
                <h2>Alquilar vehiculo con matricula: $this->matricula</h2>
                

                <label for="FechaIni">Fecha de inicio:</label>
                <input id="fechaIni" type="date" name="fechaIni" value="$fechaIni" />
                {$erroresCampos['fechaIni']}
                
               
                <label for="FechaFin">Fecha de fin:</label>
                <input id="fechaFin" type="date" name="fechaFin" value="$fechaFin" />
                {$erroresCampos['fechaFin']}
            
                <button class="botonIni" type="submit" name="registro">Registrar</button>
        
        </div>
        EOF;
        return $html;

    }
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];    
        $fechaIni = $datos['fechaIni'] ?? null;
        
        if (empty($fechaIni)) {
            $this->errores['fechaIni'] = "La fecha de inicio no puede estar vacía";
        }


        $fechaFin = $datos['fechaFin'] ?? null;
     
        
        if (empty($fechaFin)) {
            $this->errores['fechaFin'] = "La fecha de fin no puede estar vacía";
        }
        if (count($this->errores) === 0) {
            $vehiculo=Vehiculo::buscaPorId($this->id_vehiculo);
            Vehiculo::cambiarDisponibilidad($vehiculo);
            Alquilar::crea($this->id_usuario, $this->id_vehiculo, $fechaIni, $fechaFin);
                 
             
             
        
        }

    
    }
}