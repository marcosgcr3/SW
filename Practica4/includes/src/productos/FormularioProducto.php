<?php

namespace es\ucm\fdi\aw\productos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
require_once 'includes/src/productos/producto.php';





class FormularioProducto extends Formulario{

    public function __construct() {
        parent::__construct('formProducto', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('tienda.php')]);
    }
    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $precio = $datos['precio'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $unidades = $datos['unidades'] ?? '';
        $imagen = $datos['imagen'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'precio', 'archivado', 'descripcion', 'unidades', 'imagen'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <div class="container-registro">
            
                <label for="Nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
                
                <label for="Precio">Precio:</label>
                <input id="precio" type="text" name="precio" value="$precio" />
                {$erroresCampos['precio']}

                <label for="Archivado">Archivado:</label>
                <input id="archivado" type="text" name="archivado" value="$archivado" />
                {$erroresCampos['archivado']}
                
                <label for="Descripcion">Descripcion:</label>
                <input id="descripcion" type="text" name="descripcion" value="$descripcion" />
                {$erroresCampos['descripcion']}
                
                <label for="Unidades">Unidades:</label>
                <input id="unidades" type="text" name="unidades" value="$unidades" />
                {$erroresCampos['unidades']}
                
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

        $archivado = $datos['archivado'] ?? '';
        $archivado = filter_var($archivado, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $archivado || empty($archivado)) {
            $this->errores['archivado'] = 'El archivado no puede estar vacío.';
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
        
        $imagen = $datos['imagen'] ?? '';
        $imagen = filter_var($imagen, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $imagen    || empty($imagen)) {
            $this->errores['imagen'] = 'La imagen no puede estar vacía.';
        }
    
      
        if (count($this->errores) === 0) {
           
            $producto = Producto::buscaPorNombre($nombre);
            if ($producto) {
                $this->errores['nombre'] = 'Ya existe un producto con ese nombre';
               
            }else{
                
              Producto::crea($nombre, $precio, $archivado, $descripcion, $unidades, $imagen);  
            
            }
            
            
       
        }
    }

}