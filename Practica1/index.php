<?php
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
       
        

        <div class="imagen">
        
        
        <?php
        
            if ($modoOscuro) {
                echo '<img src="img/LogoFondoInvertido.png" id="imagenPrincipal" alt="centrado">';
            }else{
                echo '<img src="img/LogoFondo.png" id="imagenPrincipal" alt="centrado">';}
        ?>

        </div>

        <div class="text">
            <h1>DriveCrafters</h1>
            <p>Estamos entusiasmados de presentar una iniciativa innovadora que revolucionará la forma en que experimentamos el mantenimiento y reparación de vehículos. Nuestra cadena de talleres está diseñada para ofrecer un servicio integral y eficiente, aprovechando la tecnología de vanguardia y un enfoque centrado en la comodidad del cliente.
            En nuestro proyecto, nos comprometemos a proporcionar una experiencia sin complicaciones para los propietarios de vehículos, combinando la excelencia técnica con la conveniencia moderna. Implementaremos un sistema de programación en línea fácil de usar que permite a los clientes reservar citas en cualquier momento y desde cualquier lugar. Esto no solo simplifica el proceso, sino que también optimiza la gestión del tiempo tanto para nuestros clientes como para nuestros talleres.
            Esto no solo acelera el proceso de reparación, sino que también mejora la transparencia y la confianza entre nuestros clientes y nuestros técnicos.
            </p>
            <p>Para mas informacion pulse <a href="contacto.php">aqui.</a> </p>
        </div>

        <footer>
            <p>&copy; 2024 DriveCrafters - Todos los derechos reservados</p>
        </footer>
        
        <script src="js/cabecera.js"></script>
        <script src="js/index.js"></script>
        
        
    </body>
</html>