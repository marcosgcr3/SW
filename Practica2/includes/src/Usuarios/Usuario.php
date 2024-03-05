<?php

class Usuario
{

    use MagicProperties;

    public const ADMIN_ROLE = 'admin';

    public const USER_ROLE = 'user';

    public const MECANICO_ROLE = 'mecanico';
    
    public static function login($NIF, $password)
    {$usuario = self::buscaPorNIF($NIF);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        }
        return false;
    }
    
    public static function crea($NIF, $nombre,$apellido, $correo ,$password,$rol)
    {
        $user = new Usuario($NIF, $nombre,$apellido, $correo ,self::hashPassword($password),$rol);
        
        return $user->guarda();
    }

    public static function buscaPorNIF($NIF)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM Usuarios WHERE NIF=$NIF";
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['NIF'], $fila['nombre'], $fila['apellido'], $fila['correo'],$fila['password'], $fila['rol']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private $NIF;

    private $nombre;

    private $password;

    private $apellido;

    private $rol;

    private $correo;

    private function __construct($NIF, $nombre,$apellido,$correo, $password, $rol )
    {
        $this->NIF = $NIF;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->password = $password;
        $this->rol = $rol;

        
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function guarda()
    {
        if ($this->NIF !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }
    private static function actualiza($usuario)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Usuarios U SET NIF = '%s', nombre='%s', password='%s' WHERE U.NIF=%d"
            , $conn->real_escape_string($usuario->NIF)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $usuario->NIF
        );
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows == 0) {
                error_log("No se ha actualizado el usuario");
            }
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
       
        
        
        return $result;
    }
   

    private static function inserta($usuario)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Usuarios(NIF, nombre, apellido, correo, password, rol)
        VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
        $conn->real_escape_string($usuario->getNIF()),
        $conn->real_escape_string($usuario->getNombre()),
        $conn->real_escape_string($usuario->getApellido()),
        $conn->real_escape_string($usuario->getCorreo()),
        $conn->real_escape_string($usuario->password), // No changes here
        $conn->real_escape_string($usuario->getRol())
        );
        
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
            $result = $usuario;
        } else {
            
            file_put_contents("falloBD.txt",$query);
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    public function getNIF()
    {
        return $this->NIF;
    }
    public function getRol()
    {
        return $this->rol;
    }
    public function getCorreo()
    {
        return $this->correo;
    }

    
    public function getApellido()
    {
        return $this->apellido;
    }
    public function getNombreUsuario()
    {
        return $this->nombre;
    }
    public function compruebaPassword($password)
    {
        return $password==$this->password;
    }

}