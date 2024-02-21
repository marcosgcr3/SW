<?php
session_start();
$usuario = htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));
$password = htmlspecialchars(trim(strip_tags(md5($_REQUEST["password"]))));
$password2 = htmlspecialchars(trim(strip_tags(md5($_REQUEST["password2"]))));
$nombre = htmlspecialchars(trim(strip_tags($_REQUEST["nombre"])));
$apellidos = htmlspecialchars(trim(strip_tags($_REQUEST["apellidos"])));
$correo = htmlspecialchars(trim(strip_tags($_REQUEST["correo"])));
$NIF = htmlspecialchars(trim(strip_tags($_REQUEST["NIF"]))); 

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <link id ="estilo" rel="stylesheet" href="css/index.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Index" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>
        <title>DriveCrafters</title>
    </head>
   
    <body> 

        <div class="container-encabezado">
          <?php include("componentes/header.php"); ?>

        </div> 
       
    <?php
       

        if($password != $password2) {
            echo "Las contraseñas no coinciden";
            
        }else{
            $conn = mysqli_connect("localhost", "root", "", "DriveCrafters");
            if($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "INSERT INTO usuarios (NIF, nombre, apellido, correo, password) VALUES ('$NIF', '$nombre', '$apellidos', '$correo','$password')";
            if($conn->query($sql) === TRUE) {
                echo "Usuario registrado correctamente";
                $_SESSION["login"] = true;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $sql = "SELECT tipo_user FROM usuarios WHERE NIF = '$NIF'";
            $nombreResult = $conn->query($sql);
            $tipo = $nombreResult->fetch_assoc()["tipo_user"];
        

            $conn->close();


        }

        
        if (strlen($password) < 6 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)) {
            echo "Invalid password";
            
        }

        

        
        
    
    ?>
      <footer>
            <p>&copy; 2024 DriveCrafters - Todos los derechos reservados</p>
        </footer>
        
        <script src="js/cabecera.js"></script>
        <script src="js/index.js"></script>
        
        
    </body>
</html>