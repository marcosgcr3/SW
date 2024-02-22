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
                <img src="img/marcos.png" alt="Foto_Marcos" width="150" height="150">
                <p></p>
                <a href="mailto:marcos@ucm.es">Correo electronico Marcos</a>
                <p>Su forma redondeada y las hendiduras que tiene le ayudan a reducir su resistencia al agua y le permiten nadar 
                    a gran velocidad.</p> 
            </article>
            <article id="info_pablo">
                <h3>Pablo</h3>
                <img src="img/pablo.png"alt="Foto_Pablo" width="150" height="150">
                <p></p>
                <a href="mailto:pablo@ucm.es">Correo electronico Pablo</a>
                <p>La semilla que tiene en el lomo va creciendo cada vez más a medida que absorbe los rayos del sol.</p>
            </article>
            <article id="info_alex">
                <h3>Alex</h3>
                <img src="img/alex.png"alt="Foto_Alex" width="155" height="150">
                <p></p>
                <a href="mailto:alex@ucm.es">Correo electronico Alex</a>
                <p>La llama que tiene en la punta de la cola arde según sus sentimientos. Llamea levemente cuando está alegre y 
                    arde vigorosamente cuando está enfadado.</p>
            </article>
            <article id="info_val">
                <h3>Valentina</h3>
                <img src="img/valentina.png"alt="Foto_Valentina" width="140" height="150">
                <p></p>
                <a href="mailto:valentina@ucm.es">Correo electronico Valentina</a>
                <p>Su irregular estructura genética encierra el secreto de su capacidad para adoptar evoluciones de lo más diversas.</p>
            </article>
        </section>
        <script src="js/cabecera.js"></script>
        
    </body>
</html>