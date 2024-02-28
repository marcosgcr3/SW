<?php
session_start();
$modoOscuro = isset($_COOKIE['modoOscuro']) && $_COOKIE['modoOscuro'] === 'activado';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <?php
        
            if ($modoOscuro) {
                echo '<link id ="estilo" rel="stylesheet" href="css/indexNight.css">';
            }else{
                echo '<link id ="estilo" rel="stylesheet" href="css/index.css">';}
       ?>
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

        <div class="container-registro">
            <h2>Login Usuario</h2>

            <form action="ProcesaLogin.php" method="post">
                
                <p>NIF:</p>
                <input type="text" name="NIF" id="NIF" required>
                <p>Contraseña:</p>
                
                <input type="password" name="password" id="password" required>
                <p></p>
                <input type="submit" value="Registrarse">
            </form>
        </div>
        
        

       

        
        <?php include("componentes/pie.php"); ?>
        
        <script src="js/cabecera.js"></script>
        <script src="js/index.js"></script>
        
        
    </body>
</html>