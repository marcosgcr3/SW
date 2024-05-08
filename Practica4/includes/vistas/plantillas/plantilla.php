<?php


$modoOscuro = isset($_COOKIE['modoOscuro']) && $_COOKIE['modoOscuro'] === 'activado';
use es\ucm\fdi\aw\Aplicacion;
$params['app']->doInclude('/vistas/helpers/plantilla.php');
$mensajes = mensajesPeticionAnterior();
$app = Aplicacion::getInstance();
?>
<!DOCTYPE html>
<html>
<head>
	
   
	
	<?php
       
	   if ($modoOscuro) {
		echo '<link id ="estilo" rel="stylesheet" href="css/indexNight.css">';
		}else{
		echo '<link id ="estilo" rel="stylesheet" href="css/index.css">';}
	?>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>
	
	<title><?= $params['tituloPagina'] ?></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    
    
    <?php
    /*
    $scripts = $scripts ?? [];
    foreach ($scripts as $scriptSrc) {
        echo "<script src=\"$scriptSrc\"></script>";        
    }
    */
    ?>


	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script>
        $(document).ready(function() {
            $('#dia').change(function() {
                var diaSeleccionado = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'actualizaHorario.php', // Ruta al archivo que procesará la solicitud AJAX
                    data: {'dia': diaSeleccionado},
                    success: function(data) {
                        $('#hora').html(data);
                    }
                });
            });
        });
    </script>
</head>
<body>
<?= $mensajes ?>

<div class="container-encabezado">
<?php
$params['app']->doInclude('/vistas/comun/header.php', $params);

?>
</div>	


<?=$params['contenidoPrincipal'] ?>
		
<?php

$params['app']->doInclude('/vistas/comun/pie.php', $params);
?>

<script src="js/cabecera.js"></script>

</body>
</html>
