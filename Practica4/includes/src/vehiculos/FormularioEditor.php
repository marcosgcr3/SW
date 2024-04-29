<?php

namespace es\ucm\fdi\aw\vehiculos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\vehiculos\vehiculo;






class FormularioEditor extends Formulario{
    private $matricula;
    public function __construct($matricula) {

        parent::__construct('formVehiculoEditor', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('alquiler.php')]);
        $this->matricula = $matricula;
    }

    protected function generaCamposFormulario(&$datos){
        $vehiculo = Vehiculo::buscaPorMatricula($this->matricula);
        $matricula = $vehiculo->getMatricula();
        $marca = $vehiculo->getMarca();
        $modelo = $vehiculo->getModelo();
        $precio = $vehiculo->getPrecio();
        $year = $vehiculo->getYear();
        $disponibilidad = $vehiculo->getDisponibilidad();
        $imagen = $vehiculo->getImagen();


        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['matricula', 'marca', 'modelo', 'precio', 'year', 'disponibilidad', 'imagen'], $this->errores, 'span', array('class' => 'error'));
        
        $html = <<<EOF
        $htmlErroresGlobales
        <div class="container-registro">
                
                <label for="Matricula">Matricula:</label>
                <input id="matricula" type="text" name="matricula" value="$this->matricula" readonly />
                {$erroresCampos['matricula']}
                
                <label for="Marca">Marca:</label>
                <input id="marca" type="text" name="marca" value="$marca" />
                {$erroresCampos['marca']}
                
                <label for="Modelo">Modelo:</label>
                <input id="modelo" type="text" name="modelo" value="$modelo" />
                {$erroresCampos['modelo']}
                
                <label for="Precio">Precio:</label>
                <input id="precio" type="text" name="precio" value="$precio" />
                {$erroresCampos['precio']}
                
                <label for="Year">Year:</label>
                <input id="year" type="text" name="year" value="$year" />
                {$erroresCampos['year']}

                <label for="Disponibilidad">Disponibilidad:</label>
                <input id="disponibilidad" type="text" name="disponibilidad" value="$disponibilidad" />
                {$erroresCampos['year']}

                <label for="Imagen">Imagen:</label>
                <input id="imagen" type="text" name="imagen" value="$imagen" />
                {$erroresCampos['imagen']}
            
                <button class="botonIni" type="submit" name="registro">Registrar</button>
        
        </div>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $matricula = $datos['matricula'] ?? '';
        
        $matricula = filter_var($matricula, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $matricula || empty($matricula) ) {
            $this->errores['matricula'] = 'El matricula no puede estar vacío';
        }
        
        $precio = $datos['precio'] ?? '';
        $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $precio || empty($precio) ) {
            $this->errores['precio'] = 'El precio no puede estar vacío.';
        }
        
        $marca = $datos['marca'] ?? '';
        $marca = filter_var($marca, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $marca || empty($marca) ) {
            $this->errores['marca'] = 'La marca no puede estar vacía.';
        }
        $modelo = $datos['modelo'] ?? '';
        $modelo = filter_var($modelo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $modelo || empty($modelo) ) {
            $this->errores['modelo'] = 'Las year no pueden estar vacías.';
        }
        
        $year = $datos['year'] ?? '';
        $year = filter_var($year, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $year || empty($year) ) {
            $this->errores['year'] = 'Las year no pueden estar vacías.';
        }

        $disponibilidad = $datos['disponibilidad'] ?? '';
        $disponibilidad = filter_var($disponibilidad, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ( !$disponibilidad || empty($disponibilidad) || ($disponibilidad != "si" && $disponibilidad != "no")  ) {
            $this->errores['disponibilidad'] = 'Formato no valido para la dsiponibilidad.';
        }
        
        $imagen = $datos['imagen'] ?? '';
        $imagen = filter_var($imagen, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $imagen || empty($imagen) ) {
            $this->errores['imagen'] = 'La imagen no puede estar vacía.';
        }
        if (count($this->errores) === 0) {
           //$vehiculo = Vehiculo::buscaPorMatricula($matricula); 
            //$vehiculo->actualiza2($matricula, $marca, $modelo, $precio, $year,$imagen, $id);
            $vehiculo = Vehiculo::actualiza2($matricula, $marca, $modelo, $precio, $year, $disponibilidad, $imagen);
            if ($vehiculo) {
                echo "El vehículo ha sido actualizado correctamente.";
            } else {
                echo "Ha ocurrido un error al intentar actualizar el vehículo.";
            }
       
        }
        else{
            echo "Ha ocurrido un error al intentar actualizar el vehículo."; 
        }
    }

    
    
    
    


}