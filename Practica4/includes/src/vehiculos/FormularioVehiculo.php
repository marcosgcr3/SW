<?php

namespace es\ucm\fdi\aw\vehiculos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\vehiculos\vehiculo;






class FormularioVehiculo extends Formulario{

    const EXTENSIONES_PERMITIDAS = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');

    public function __construct() {
        parent::__construct('formVehiculo', ['enctype' => 'multipart/form-data', 'urlRedireccion' => Aplicacion::getInstance()->resuelve('alquiler.php')]);
    }

    protected function generaCamposFormulario(&$datos){

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['matricula', 'marca', 'modelo', 'precio', 'year', 'imagen'], $this->errores, 'span', array('class' => 'error'));

        $matricula = $datos['matricula'] ?? '';
        $marca = $datos['marca'] ?? '';
        $modelo = $datos['modelo'] ?? '';
        $precio = $datos['precio'] ?? '';
        $year = $datos['year'] ?? '';
        $imagen = $datos['imagen'] ?? '';

                
        $html = <<<EOF
        $htmlErroresGlobales
        <div class="container-registro">
                
                <label for="Matricula">Matricula:</label>
                <input id="matricula" type="text" name="matricula" value="$matricula" />
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

                <label for="imagen">Imagen:</label>
                <input id="imagen" type="file" name="imagen"/>
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
        
        /*
        $imagen = $datos['imagen'] ?? '';
        $imagen = filter_var($imagen, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $imagen || empty($imagen) ) {
            $this->errores['imagen'] = 'La imagen no puede estar vacía.';
        }
        */
        
        $ok = $_FILES['imagen']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1;
        if(!$ok){
            $this->errores['imagen'] = 'Error en la subida de la imagen';
            return;
        }

        $nombreArchivo = $_FILES['imagen']['name'];
        //Valida el nombre del archivo 
        $ok = self::check_file_uploaded_name($nombreArchivo) && self::check_file_uploaded_length($nombreArchivo);  
        //Comprueba si la extension esta permitida
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $ok = $ok && in_array($extension, self::EXTENSIONES_PERMITIDAS);
        //Comprueba el tipo mime del archivo corresponde a una imagen image
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES['imagen']['tmp_name']);
        $ok = $ok && preg_match('/image\/.+/', $mimeType) === 1;
        if(!$ok){
            $this->errores['imagen'] = 'La imagen no es válida';
        }
        if(count($this->errores) > 0){
            return;
        }
        $tmp_name = $_FILES['imagen']['tmp_name'];
        $fichero = "{$nombreArchivo}";
        $ruta = "img/imgVehiculos/$fichero";
        if(!move_uploaded_file($tmp_name, $ruta)){
            $this->errores['imagen'] = 'Error al mover el archivo';
            return;
        }

        if (count($this->errores) === 0) {
           $vehiculo = Vehiculo::buscaPorMatricula($matricula);
           if($vehiculo){
               $this->errores['matricula'] = 'Ya existe un vehiculo con esa matricula';
            }
            else{
               
                Vehiculo::crea($matricula, $marca, $modelo, $precio, $year, $ruta);
            }
           
                
            
            
       
        }
    }

    private static function check_file_uploaded_name($filename){
        return (bool) ((preg_match('/^[0-9A-Z-_\.]+$/i', $filename) === 1) ? true : false);
    }

    private function check_file_uploaded_length($filename)
    {
        return (bool) ((mb_strlen($filename, 'UTF-8') < 250) ? true : false);
    }
}