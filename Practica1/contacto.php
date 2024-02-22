<!DOCTYPE html>
<html lang="es">
  <head>
    <link id ="estilo" rel="stylesheet" href="css/index.css" />
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
              autocomplete="off"
              required

            />
          </div>
          <div class="email">
            <label for="email">E-mail:</label>
            <input
              type="email"
              name="email"
              id="email"
              size="40"
              placeholder="Ingresa tu correo electronico"
              class="campo"
              autocomplete="off"
              required
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
              checked
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
            <textarea id="consultaBox" name="comentario" rows="15" cols="80" placeholder="Ingresa tu consulta" autocomplete="off" required></textarea>
          </div>
          <div class="checkbox">
            <input
              id="mycheckbox"
              type="checkbox"
              name="Terminos y conndiciones"
              value="on"
              autocomplete="off"
              required
            />
            <label for="mycheckbox">Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio</label>
          </div>
        </fieldset>
        <button class="button" id="myButton" type="submit" name="submit" value="Enviar form.">
          Enviar
        </button>
      </form>
    </div>
    <script src="js/contactos.js"></script>
    <script src="js/cabecera.js"></script>
  </body>
</html>
