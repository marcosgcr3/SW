<<<<<<< HEAD
<?php
    session_start();
    $modoOscuro = isset($_COOKIE['modoOscuro']) && $_COOKIE['modoOscuro'] === 'activado';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
   
        <?php
         // Agrega aquí tus estilos adicionales según el estado de $modoOscuro

        if ($modoOscuro) {
            echo '<link id ="estilo" rel="stylesheet" href="css/indexNight.css">';
        }else{
            echo '<link id ="estilo" rel="stylesheet" href="css/index.css">';}
        ?>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="miCuenta" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>
        
        <title>DriveCrafters</title>
    </head>
   
    <body> 

        <div class="container-encabezado">
          <?php include("componentes/header.php"); ?>

        </div> 
       
        

       <div class = "exit">
      
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
        

       </div> 
       
        <footer>
            <p>&copy; 2024 DriveCrafters - Todos los derechos reservados</p>
        </footer>
        
        <script src="js/cabecera.js"></script>
        <script src="js/index.js"></script>
        
        
    </body>
=======
<?php
    session_start();
    $modoOscuro = isset($_COOKIE['modoOscuro']) && $_COOKIE['modoOscuro'] === 'activado';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
   
        <?php
         // Agrega aquí tus estilos adicionales según el estado de $modoOscuro

        if ($modoOscuro) {
            echo '<link id ="estilo" rel="stylesheet" href="css/indexNight.css">';
        }else{
            echo '<link id ="estilo" rel="stylesheet" href="css/index.css">';}
        ?>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="miCuenta" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>
        
        <title>DriveCrafters</title>
    </head>
   
    <body> 

        <div class="container-encabezado">
          <?php include("componentes/header.php"); ?>

        </div> 
       
        

       <div class = "exit">
      
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
        

       </div> 
       
        <footer>
            <p>&copy; 2024 DriveCrafters - Todos los derechos reservados</p>
        </footer>
        
        <script src="js/cabecera.js"></script>
        <script src="js/index.js"></script>
        
        
    </body>
>>>>>>> c3d2392ea84a67af5b94d706eb9fe1d48bf813d7
</html>