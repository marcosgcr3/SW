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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>
        <title>Planificacion</title>
    </head>
    <body>
        <div class="container-encabezado">
            <?php include("componentes/header.php"); ?>
        </div>
        <h1>Planificacion</h1>
        <p>En esta página se describe la planificación del proyecto. Este proyecto lo que se pretende es realizar una Aplicacion Web completa
            y funcional, en incremental mediante entregas.</p>
        <section>
            <h2>Planificacion de la practica</h2>
            <table>
               <tbody>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha de entrega</th>
                        <th>Actividad</th>
                    </tr>
                    <tr>
                        <td>Practica 1</td>
                        <td>23/02/2024</td>
                        <td>Pagina web sencilla, formada por varios documentos, incluyendo imágenes, tablas y formularios</td>
                    </tr>
                    <tr>
                        <td>Practica 2</td>
                        <td>8/03/2024</td>
                        <td>Arquitectura y prototipo funcional del proyecto.</td>
                    </tr>
                    <tr>
                        <td>Practica 3</td>
                        <td>12/04/2024</td>
                        <td>Diseño del proyecto y más funcionalidades</td>
                    </tr>
               </tbody> 
            </table>
        </section>
        <section>
            <h2>Diagrama de Gantt</h2>
            <h3>Practica 1</h3>
            <img src="img/gantt1.png" alt="Gantt Practica 1" width="700" height="300">
            <h3>Practica 2</h3>
            <img src="img/gantt2.png" alt="Gantt Pratica 2" width="750" height="220">
            <h3>Practica 3</h3>
            <img src="img/gantt3.png" alt="Gantt Practica 3" width="1000" height="220">
        </section>
    
        <?php include("componentes/pie.php"); ?>
        <script src="js/cabecera.js"></script>
    </body>
    

</html>
