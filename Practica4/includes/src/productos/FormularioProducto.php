<?php

namespace es\ucm\fdi\aw\productos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
require_once 'includes/src/productos/producto.php';





class FormularioProducto extends Formulario{

    const EXTENSIONES_PERMITIDAS = array('gif', 'jpg', 'jpe', 'jpeg', 'png', 'webp', 'avif');

    public function __construct() {
        parent::__construct('formProducto', ['enctype' => 'multipart/form-data', 'urlRedireccion' => Aplicacion::getInstance()->resuelve('tienda.php')]);
    }
    protected function generaCamposFormulario(&$datos)
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'precio', 'descripcion', 'unidades', 'imagen'], $this->errores, 'span', array('class' => 'error'));

        $nombre = $datos['nombre'] ?? '';
        $precio = $datos['precio'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $unidades = $datos['unidades'] ?? '';
        $imagen = $datos['imagen'] ?? '';
    

        $html = <<<EOF
        $htmlErroresGlobales
        <div class="container-registro">
            
                <label for="Nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
                
                <label for="Precio">Precio:</label>
                <input id="precio" type="text" name="precio" value="$precio" />
                {$erroresCampos['precio']}

                <label for="Descripcion">Descripcion:</label>
                <input id="descripcion" type="text" name="descripcion" value="$descripcion" />
                {$erroresCampos['descripcion']}
                
                <label for="Unidades">Unidades:</label>
                <input id="unidades" type="text" name="unidades" value="$unidades" />
                {$erroresCampos['unidades']}
                
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
        $nombre = $datos['nombre'] ?? '';
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre ||  empty($nombre) ) {
            $this->errores['nombre'] = 'El nombre no puede estar vacío';
        }
        
        $precio = $datos['precio'] ?? '';
        $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $precio  || empty($precio)) {
            $this->errores['precio'] = 'El precio no puede estar vacío.';
        }
        
        $descripcion = $datos['descripcion'] ?? '';
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $descripcion || empty($descripcion) ) {
            $this->errores['descripcion'] = 'La descripcion no puede estar vacía.';
        }
        
        $unidades = $datos['unidades'] ?? '';
        $unidades = filter_var($unidades, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $unidades || empty($unidades)) {
            $this->errores['unidades'] = 'Las unidades no pueden estar vacías.';
        }

        /*
        $imagen = $datos['imagen'] ?? '';
        $imagen = filter_var($imagen, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $imagen    || empty($imagen)) {
            $this->errores['imagen'] = 'Tiene que seleccionar una imagen.';
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
        $ruta = "img/imgProductos/$fichero";
        if(!move_uploaded_file($tmp_name, $ruta)){
            $this->errores['imagen'] = 'Error al mover el archivo';
            return;
        }
      
        if (count($this->errores) === 0) {

            $producto = Producto::buscaPorNombre($nombre);
            $archivado = 0; //por defecto no esta archivado
            if ($producto) {
                $this->errores['nombre'] = 'Ya existe un producto con ese nombre';
               
            }else{
                
              Producto::crea($nombre, $precio, $archivado, $descripcion, $unidades, $ruta);  
            
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

