<?php 




namespace es\ucm\fdi\aw\pedidos;




use es\ucm\fdi\aw\Formulario;

use es\ucm\fdi\aw\Aplicacion;


use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\productos\producto;

require_once 'includes/src/productos/producto.php';

require_once 'includes/src/pedidos/Pedidos.php';










class FormularioPedido extends Formulario{

    public function __construct() {

        parent::__construct('formPedido', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/tienda.php')]);//no se que php poner aqui

    }




    protected function generaCamposFormulario(&$datos)

    {

        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco

        $nombre = $datos['nombre'] ?? '';

        $unidades = $datos['unidades'] ?? '';




        // Se generan los mensajes de error si existen.

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        $erroresCampos = self::generaErroresCampos(['nombre', 'unidades'], $this->errores, 'span', array('class' => 'error'));




        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.




        $html = <<<EOF

        $htmlErroresGlobales

        <input id="nombre" type="hidden" name="nombre" value="$nombre" />

        {$erroresCampos['nombre']}

        <input id="unidades" type="hidden" name="unidades" value="$unidades" />

        <button type="submit">Añadir al carrito</button>

        EOF;




        return $html;

    }




    protected function procesaFormulario(&$datos){

        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');

        $unidades = trim($datos['unidades'] ?? ''); 

        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $unidades = filter_var($unidades,FILTER_SANITIZE_NUMBER_INT);

        if ( ! $nombre || empty($nombre) ) {

            $this->errores['nombre'] = 'El nombre no puede estar vacío';

        }        

        if ( ! $unidades || empty($unidades) ) {

            $this->errores['unidades'] = 'Las unidades no pueden estar vacías';

        }

        if (count($this->errores) === 0) {

            //no necesito el nombre, necesito el id del producto

            //llamada a la base de datos para obtener el id del producto

            $id_producto = producto::devolverId($nombre);

            $id_usuario = $_SESSION['id'];

            $pedido = Pedidos::buscarCarrito($id_usuario); 

            if($pedido == NULL){//si no existe el carrito, lo creo

                $pedido = Pedidos::crea($id_usuario, 0, 0);

            }

            else{//ya tiene carrito este usuario, añado el producto al carrito

                $pedido->añadirProducto($id_producto, $unidades);

            }

        }




        //

        $this->errores = [];

        $NIF = trim($datos['NIF'] ?? '');

        $NIF = filter_var($NIF, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $NIF || empty($NIF) ) {

            $this->errores['NIF'] = 'El NIF no puede estar vacío';

        }




        $password = trim($datos['password'] ?? '');

        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( ! $password || empty($password) ) {

            $this->errores['password'] = 'El password no puede estar vacío.';

        }




        if (count($this->errores) === 0) {

            $usuario = Usuario::login($NIF, $password);




            if (!$usuario) {

                $this->errores[] = "El NIF o la contraseña no coinciden";

            } else {




                $app = Aplicacion::getInstance();

                $app->login($usuario);

            }

        }

    }

}