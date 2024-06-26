<?php

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion as App;

class Usuario
{

  public static function login($username, $password)
  {
    $user = self::buscaUsuario($username);
    if (!$user) {
      throw new UsuarioNoEncontradoException("No se puede encontrar al usuario: $username");    
    }
    
    if (!$user->compruebaPassword($password)) {
      return false;
    }

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf('SELECT R.nombre FROM RolesUsuario RU, Roles R WHERE RU.rol = R.id AND RU.usuario=%s', $conn->real_escape_string($user->id));
    $rs = $conn->query($query);
    if ($rs) {
      while($fila = $rs->fetch_assoc()) { 
        $user->addRol($fila['nombre']);
      }
      $rs->free();
    }
    return $user;
  }

  public static function buscaUsuario($username)
  {
    if (empty($username)) {
      throw new \BadMethodCallException('$username no puede ser una cadena vacía o nulo');
    }
    
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM Usuarios WHERE username='%s'", $conn->real_escape_string($username));
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      $fila = $rs->fetch_assoc();
      $user = new Usuario((int)$fila['id'], $fila['username'], $fila['password']);
      $rs->free();

      return $user;
    }
    
    throw new UsuarioNoEncontradoException("No se puede encontrar al usuario: $username");    
  }

  public static function buscaPorId($id)
  {
    
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM Usuarios WHERE id=%d", $id);
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      $fila = $rs->fetch_assoc();
      $user = new Usuario((int)$fila['id'], $fila['username'], $fila['password']);
      $rs->free();

      return $user;
    }
    throw new UsuarioNoEncontradoException("No se puede encontrar al usuario con id: $id");    
  }

  private $id;

  private $username;

  private $password;

  private $roles;

  private function __construct($id, $username, $password)
  {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
    $this->roles = [];
  }

  public function id()
  {
    return $this->id;
  }

  public function addRol($role)
  {
    $this->roles[] = $role;
  }

  public function roles()
  {
    return $this->roles;
  }

  public function username()
  {
    return $this->username;
  }

  public function compruebaPassword($password)
  {
    return password_verify($password, $this->password);
  }

  public function cambiaPassword($nuevoPassword)
  {
    $this->password = password_hash($nuevoPassword, PASSWORD_DEFAULT);
  }
}
