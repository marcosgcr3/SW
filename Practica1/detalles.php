<?php
    $modoOscuro = isset($_COOKIE['modoOscuro']) && $_COOKIE['modoOscuro'] === 'activado';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        
        if ($modoOscuro) {
            echo '<link id ="estilo" rel="stylesheet" href="css/indexNight.css">';
        }else{
            echo '<link id ="estilo" rel="stylesheet" href="css/index.css">';}
   ?>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"/>
    <title>Detalles</title>
  </head>
  
<body>
    <div class="container-encabezado">
        <?php include("componentes/header.php"); ?>

    </div>
    <h2>Introducción</h2>
        <p>DriveCrafters es una aplicación móvil y web que te permite reservar y pagar 
            los servicios de mantenimiento y reparación de tu vehículo de forma rápida, fácil 
            y segura. Con DriveCrafters, no tendrás que preocuparte por  
            comparar precios, esperar colas o recibir facturas sorpresa. Todo lo podrás hacer 
            desde tu smartphone o tu ordenador, con solo unos pocos clics.
        </p>
    <h2>Tipos de Usuarios</h2>
        <ul>
            <li><strong>Gerente</strong></li>
                <p>
                    Tendrá acceso total a los datos tanto de las resevas, los horarios de los mecánicos 
                    y el inventario de la tienda. Se encargará de la gestion de todos estos datos y la
                    organización del taller.
                </p>
            <li><strong>Mecánico</strong></li>
                <p>
                    Tendrá acceso a su horario de trabajo donde podrá visualizar todas las reservas 
                    que se le haya asignado el Administrador. Podrá marcar aquellos trabajos que ya 
                    haya realizado.
                </p>
            <li><strong>Cliente</strong></li>
                <p>
                    Tendrá una cuenta registrada en la base de datos y le dará acceso a ciertos servicios 
                    que le proporciona el taller como hacer compras de productos y pedir citas en el taller.
                </p>
            <li><strong>Usuario no registrado</strong></li>
                <p>
                    Unicamente podrá navegar por la página web pero no podrá realizar pedidos ni citas.
                </p>
        </ul>
    <h2>Funcionalidades</h2>
        <ul>
            <li><strong>Tienda</strong></li>
                <p>
                    Sección de la página donde habrá un amplio catálogo de diversos productos
                    y componentes para todo tipo de coches y modelos. Lo podrán realizar los clientes 
                    para comprar los productos y el gerente se encargará del inventario de los mismos.
                </p>
            <li><strong>Citas y horarios de mecánicos</strong></li>
                <p>
                    Un cliente pedirá una cita para el taller para ciertos servicios de reparación 
                    y el gerente delegará cada cita a un mecánico. Además los mecánicos podrán ver 
                    su horario para esa jornada. 
                </p>
        <li><strong>Alquiler de vehículos</strong></li>
                <p>
                    Un cliente podrá alquilar un vehículo durante un periodo de tiempo y el gerente 
                    se encarga del inventario de los vehículos.
                </p>
        </ul>
    
    <?php include("componentes/pie.php"); ?>
        <script src="js/cabecera.js"></script>
</body>
</html>
