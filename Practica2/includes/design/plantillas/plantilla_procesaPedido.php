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

        <div class="header">
          <?php require("header.php"); ?>

        </div> 
       
        <main>
		    <div class="contenido">
			    <?= $params['contenidoPrincipal'] ?>
			        <?php 
				        $id = $params['id'];
                        $carrito = $_GET["carro"]
                        if(!$carrito){
                            mostrar_carrito();
                        }
                        else{
                            mostrar_pedido();
                        }                        
                    ?>
		    </div>
	    </main>
       
        <?php require("pie.php"); ?>
        <script src="js/cabecera.js"></script>
        <script src="js/index.js"></script>
        
        
    </body>
</html>