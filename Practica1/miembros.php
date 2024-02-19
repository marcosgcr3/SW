<!DOCTYPE html>
<html lang="es">
    <head>
        <link id ="estilo" rel="stylesheet" href="css/index.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>
        <title>Miembros</title>
    </head>
    <body>
        <div class="container-encabezado">
            <?php include("componentes/header.php"); ?>
  
        </div>
            
        <h1>Miembros</h1>
            <ul>
                <li><a href="#info_marcos" > Marcos </a> </li>
                <li><a href="#info_pablo" > Pablo </a> </li>
                <li><a href="#info_alex" > Alex </a> </li>
                <li><a href="#info_val" > Val </a> </li>
            </ul>
        <section>
            <h2>Informacion de los miembros del grupo</h2>
            <article id="info_marcos">
                <h3>Marcos</h3>
                <a href="mailto:marcos@ucm.es">Correo electronico Marcos</a>
                <img src="img/marcos.png" alt="Foto_Marcos" width="150" height="150">
                <p>Descripcion de Marcos</p> 
            </article>
            <article id="info_pablo">
                <h3>Pablo</h3>
                <a href="mailto:pablo@ucm.es">Correo electronico Pablo</a>
                <img src="img/pablo.png"alt="Foto_Pablo" width="150" height="150">
                <p>Descripcion de Pablo</p>
            </article>
            <article id="info_alex">
                <h3>Alex</h3>
                <a href="mailto:alex@ucm.es">Correo electronico Alex</a>
                <img src="img/alex.png"alt="Foto_Alex" width="155" height="150">
                <p>Descripcion de Alex</p>
            </article>
            <article id="info_val">
                <h3>Valentina</h3>
                <a href="mailto:valentina@ucm.es">Correo electronico Valentina</a>
                <img src="img/valentina.png"alt="Foto_Valentina" width="140" height="150">
                <p>Descripcion de Valentina</p>
            </article>
        </section>
        <script src="js/cabecera.js"></script>
        
    </body>
</html>