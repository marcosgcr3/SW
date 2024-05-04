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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<title><?= $params['tituloPagina'] ?></title>
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
