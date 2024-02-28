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
        <div class="noRegistrado">
            <h1>LO SIENTO DEBES HABER INICIADO SESION 
                    PARA ACCEDER A ESTE APARTADO</h1>
        </div>
        <div class="noRegistrado">
            
          <img src="img/NOO.png" id="noUser" alt="centrado">

            
        </div>
        <button class="botonIni" onclick="location.href='login.php'">LOGIN/REGISTER</button>
       

       
        <?php include("componentes/pie.php"); ?>
        <script src="js/cabecera.js"></script>
        <script src="js/index.js"></script>
        
        
    </body>
</html>