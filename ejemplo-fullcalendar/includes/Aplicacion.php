<?php
namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\dao\BdException;


class Aplicacion
{

  private static $instancia;

  private $bdDatosConexion;

  private $rutaRaizApp;

  private $dirInstalacion;
  
  private $conn;

  public static function getSingleton()
  {
      if (  !self::$instancia instanceof self) {
         self::$instancia = new self;
      }
      return self::$instancia;
  }

  private function __construct()
  {
  }
  /**
   * Evita que se pueda utilizar el operador clone.
   */
  public function __clone()
  {
    throw new \Exception('No tiene sentido el clonado');
  }

    
  /**
   * Evita que se pueda utilizar serialize().
   */
  public function __sleep()
  {
    throw new \Exception('No tiene sentido el serializar el objeto');
  }
  
  /**
   * Evita que se pueda utilizar unserialize().
   */
  public function __wakeup()
  {
    throw new \Exception('No tiene sentido el deserializar el objeto');
  }

  public function init($bdDatosConexion, $rutaRaizApp, $dirInstalacion)
  {
    $this->bdDatosConexion = $bdDatosConexion;

    $this->rutaRaizApp = $rutaRaizApp;
    $tamRutaRaizApp = mb_strlen($this->rutaRaizApp);
    if ($tamRutaRaizApp > 0 && $this->rutaRaizApp[$tamRutaRaizApp-1] !== '/') {
      $this->rutaRaizApp .= '/';
    }

    $this->dirInstalacion = $dirInstalacion;
    $tamDirInstalacion = mb_strlen($this->dirInstalacion);
    if ($tamDirInstalacion > 0 && $this->dirInstalacion[$tamDirInstalacion-1] !== '/') {
      $this->dirInstalacion .= '/';
    }

    $this->conn = null;
    session_start();
  }

  public function resuelve($path = '')
  {
    $rutaRaizAppLongitudPrefijo = mb_strlen($this->rutaRaizApp);
    if( mb_substr($path, 0, $rutaRaizAppLongitudPrefijo) === $this->rutaRaizApp ) {
      return $path;
    }

    if (mb_strlen($path) > 0 && $path[0] == '/') {
      $path = mb_substr($path, 1);
    }
    return $this->rutaRaizApp . $path;
  }

  public function doInclude($path = '')
  {
    $params = array();
    $this->doIncludeInterna($path, $params);
  }
  
  private function doIncludeInterna($path, &$params)
  {  
    if (mb_strlen($path) > 0 && $path[0] == '/') {
      $path = mb_substr($path, 1);
    }
    include($this->dirInstalacion . '/'.$path);
  }
  
  public function generaVista(string $rutaVista, array &$params)
  {
    $params['app'] = $this;
    $this->doIncludeInterna($rutaVista, $params);
  }

  public function login(Usuario $user)
  {
    $_SESSION['login'] = true;
    $_SESSION['nombre'] = $user->username();
    $_SESSION['roles'] = $user->roles();
  }

  public function logout()
  {
    //Doble seguridad: unset + destroy
    unset($_SESSION['login']);
    unset($_SESSION['nombre']);
    unset($_SESSION['roles']);


    session_destroy();
    session_start();
  }

  public function usuarioLogueado()
  {
    return ($_SESSION['login'] ?? false) === true;
  }

  public function nombreUsuario()
  {
    return $_SESSION['nombre'] ?? '';
  }

  public function conexionBd()
  {
    if (! $this->conn ) {
      $bdHost = $this->bdDatosConexion['host'];
      $bdUser = $this->bdDatosConexion['user'];
      $bdPass = $this->bdDatosConexion['pass'];
      $bd = $this->bdDatosConexion['bd'];

      /* activate reporting a.k.a exceptions */
      $driver = new \mysqli_driver();
      $driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
      
      try {
        $this->conn = new \mysqli($bdHost, $bdUser, $bdPass, $bd);
      }catch(\mysqli_sql_exception $e) {
        throw new BDException('Error de conexión a la BD', 0, $e);
      }
      
      try {
        $this->conn->set_charset("utf8mb4");
      }catch(\mysqli_sql_exception $e) {
        throw new BDException('rror al configurar la codificación de la BD', 0, $e);
      }
      
    }
    return $this->conn;
  }

  public function tieneRol($rol)
  {
    $roles = $_SESSION['roles'] ?? array();
    if (! in_array($rol, $roles)) {
      return false;
    }

    return true;
  }
}
