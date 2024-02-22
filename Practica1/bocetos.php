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
       
        

        <div class="bocetoTitulo"><h1>Bocetos</h1>
        </div>

        <div class="bocetos">
            
        <section class="boceto">
            <img src="img/inicio.png" id="inicio" alt="centrado"/>
        </section>
        <h3>Descripcion inicio</h3>
        <p>
            Pagina principal de la aplicacion, en ella tendras acceso a todas las funcionalidades en la parte superior, en el medio de la 
            pagina tendras una breve descripcion de esta con un boton permitiendote el registro o inicio de sesion, en caso de estar ya
            logeado no aparecera.
        </p>

        <section class="boceto">
            <img src="img/alquiler.png" id="alquiler" alt="centrado"/>
        </section>
        <section class="boceto">
            <img src="img/alquiler2.png" id="alquiler2" alt="centrado"/>
        </section>
        <h3>Descripcion alquiler</h3>
        <p>
            Primeramente tendremos una pagina en la cual apareceran los vehiculos disponibles para el alquiler con una pequeña descripcion
            de sus caracteristicas, ademas en la parte izquierda tendremos un pequeño buscador en el cual podemos aplicar filtros o simplemente
            buscar por su nombre.
        </p>
        <p>
            Si clickamos en el boton de alquilar nos dirigira a una seccion en la cual aparecera el coche deseado con una breve descripcion, al lado 
            tendremos un apartado en el cual podremos indicar cuantos dias alquilaremos el vehiculo indicando el dia de recogida y la devolucion, una 
            vez indicados nos aparecera el precio total y al clickar nuevamente en el boton de alquilar ya estara reservado para nuestro user.
        </p>

        <section class="boceto">
            <img src="img/citas1.png" id="citas general" alt="centrado"/>
        </section>
        <section class="boceto">
            <img src="img/citasmecanico.png" id="citas mecanico" alt="centrado"/>
        </section>
        <section class="boceto">
            <img src="img/citasuser.png" id="citas usuarios" alt="centrado"/>
        </section>
        <h3>Descripcion citas</h3>
        <p>
            En el primer boceto observamos la pagina la cual aparece en el apartado de citas cuando no has sido logeado, como este apartado es 
            mas personal no sera posible visualizar nada como se observa.
        </p>
        <p>
            En cambio si te has logeado seras redirigido a una pagina en funcion de tu rol. Si eres mecanico podras observar una lista de tus solicitudes
            pendientes de aprobacion, ademas en la parte derecha tendras un calendario en el cual podras modificar las citas que ya tienes aceptadas, en
            caso de modificar alguna le llegara un mensaje al cliente en para que acepte esa modificacion o no. Para el caso del cliente aparecera un 
            formulario para solicitar una cita, indicando los datos necesarios para esta, en su parte derecha en cambio le apareceran un listado con 
            las citas solicitadas y pendientes de aprobacion, las citas aceptadas y las notificaciones en caso de que el mecanico haya solicitado una
            modificacion.
        </p>

        <section class="boceto">
            <img src="img/tienda.png" id="tienda" alt="centrado"/>
        </section>
        <h3>Descripcion tienda</h3>
        <p>
            Similar a la apariencia de la seccion de alquiler, pero en este caso para articulos vendidos en la tienda, ademas en la parte superior derecha
            aparecera un simbolo en el cual podras ver el carrito actual del cliente, segun haya ido añadiendo articulos
        </p>

        <section class="boceto">
            <img src="img/registro.png" id="formulario registro" alt="centrado"/>
        </section>
        <section class="boceto">
            <img src="img/login.png" id="formulario inicio de sesion" alt="centrado"/>
        </section>
        <h3>Descripcion registro/inicio sesion</h3>
        <p>
            Diseño de los respectivos formularios para poder iniciar sesion o registrarse en la pagina
        </p>


        <section class="boceto">
            <img src="img/perfil.png" id="perfil user" alt="centrado"/>
        </section>
        
        <section class="boceto">
            <img src="img/mecanico.png" id="perfil mecanico" alt="centrado"/>
        </section>
        <h3>Descripcion perfiles</h3>
        <p>
            En la primera foto observamos el boceto del perfil para el usuario normal en el cual apareceran sus respectivos datos y la posibilidad
            de registrar un nuevo vehiculo, modificar su contraseña y añadir/modificar su direccion. Para el caso del mecanico apareceran sus datos
            igual que en el usuario normal pero el solo podra modificar su contraseña y tambien tendra un pequeño calendario con las proximas citas 
            a modo de recordatorio, pero no podra realizar ninguna modificacion en estas.
        </p>

        <section class="boceto">
            <img src="img/contacto.png" id="contacto" alt="centrado"/>
        </section>
        <h3>Descripcion contacto</h3>
        <p>
            Diseño de la visualizacion del apartado de contacto para poder realizar alguna queja o recibir atencion al cliente
        </p>

        </div>
        <footer>
            <p>&copy; 2024 DriveCrafters - Todos los derechos reservados</p>
        </footer>
        
        <script src="js/cabecera.js"></script>
        <script src="js/index.js"></script>
        
        
    </body>
</html>