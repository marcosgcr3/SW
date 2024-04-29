<?php

namespace es\ucm\fdi\aw\productos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
require_once 'includes/src/productos/producto.php';





class FormularioEditarProducto extends Formulario{
    private $nombre;
    public function __construct($nombre) {
        parent::__construct('formEditarProducto', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('tienda.php')]);
        $this->nombre = $nombre;
    }
    protected function generaCamposFormulario(&$datos)
    {
        $producto = Producto::BuscaPorNombre($this->nombre);

        //$nombre = $producto->getNombre();
        $precio = $producto->getPrecio();
        $descripcion = $producto->getDescripcion();
        $imagen = $producto->getImagen();

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'precio', 'descripcion', 'unidades', 'imagen'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <div class="container-registro">
            
                <label for="Nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$this->nombre" readonly/>
                {$erroresCampos['nombre']}
                
                <label for="Precio">Precio:</label>
                <input id="precio" type="text" name="precio" value="$precio" />
                {$erroresCampos['precio']}

                <label for="Descripcion">Descripcion:</label>
                <input id="descripcion" type="text" name="descripcion" value="$descripcion" />
                {$erroresCampos['descripcion']}
                
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
        
        $descripcion = $datos['descripcion'] ?? '';
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $descripcion || empty($descripcion) ) {
            $this->errores['descripcion'] = 'La descripcion no puede estar vacía.';
        }
        
        $imagen = $datos['imagen'] ?? '';
        $imagen = filter_var($imagen, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $imagen    || empty($imagen)) {
            $this->errores['imagen'] = 'La imagen no puede estar vacía.';
        }
    
      
        if (count($this->errores) === 0) {
            Producto::actualiza2($nombre, $precio, $descripcion, $imagen);
            /*$producto = Producto::buscaPorNombre($nombre);
            $archivado = 0; //por defecto no esta archivado
            if ($producto) {
                $this->errores['nombre'] = 'Ya existe un producto con ese nombre';
               
            }else{
                
              //Producto::crea($nombre, $precio, $archivado, $descripcion, $unidades, $imagen);
                echo "ACtualizando producto";  
                
            }*/
            
            
       
        }
    }

}