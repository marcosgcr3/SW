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
          echo '<link  id ="estilo"rel="stylesheet" href="css/index.css">';}
    ?>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>
    <title>Contacto</title>
  </head>
  
  <body>
    <div class="container-encabezado">
    <?php include("componentes/header.php"); ?>

    </div>
    <h1>Contacto</h1>
    
    <div class="Informacion personal">
      <form action="mailto:papadial@ucm.es?" id="formulario" method="POST">
        <fieldset>  
          <legend>Información personal</legend>
          <div class="name">
            <label for="name">Nombre:</label>
            <input
              type="text"
              name="nombre"
              id="name"
              size="30"
              placeholder="Ingresa tu nombre"
              class="campo"
            />
          </div>
          <div class="email">
            <label for="email">E-mail:</label>
            <input
              type="text"
              name="email"
              id="email"
              size="40"
              placeholder="Ingresa tu correo electronico"
              class="campo"
            />
          </div>
        </fieldset>
        <fieldset>
          <legend>Motivo de la consulta</legend>
          <div class="Evaluacion">
            <input
              type="radio"
              name="motivo"
              id="evaluacion"
              value="Evaluacion"
            />
            <label for="evaluacion">Evaluación</label>
          </div>
          <div class="Sugerencias">
            <input
              type="radio"
              name="motivo"
              id="sugerencias"
              value="Sugerencias"
            />
            <label for="sugerencias">Sugerencias</label>
          </div>
          <div class="Criticas">
            <input
              type="radio"
              name="motivo"
              id="critica"
              value="Criticas"
            />
            <label for="critica">Crítica</label>
          </div>
          <div class="textbox">
            <textarea id="consultaBox" name="comentario" rows="15" cols="80" placeholder="Ingresa tu consulta"></textarea>
          </div>
          <div class="checkbox">
            <input
              id="mycheckbox"
              type="checkbox"
              name="Terminos y conndiciones"
              value="on"
              onclick="activoCheckBox()"
            />
            <label for="mycheckbox">Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio</label>
          </div>
        </fieldset>
        <button class="button" id="myButton" type="submit" name="submit" value="Enviar form." disabled>
          Enviar
        </button>
      </form>
    </div>
    
    <?php include("componentes/pie.php"); ?>
    <script src="js/contactos.js"></script>
    <script src="js/cabecera.js"></script>
  </body>
</html>