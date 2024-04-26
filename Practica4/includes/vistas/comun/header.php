
<?php
require_once 'includes/config.php';
$modoOscuro = isset($_COOKIE['modoOscuro']) && $_COOKIE['modoOscuro'] === 'activado';
use es\ucm\fdi\aw\Aplicacion;
?>
<header>
    <div class="logo">
        <a href="index.php" title="Home">
            <?php
            if ($modoOscuro) {
                echo '<img src="img/LogoFondoBNI.png" id="logoPrincipal"   alt="DriveCrafters">';
            }else{
                echo '<img src="img/LogoFondoBN.png" id="logoPrincipal"   alt="DriveCrafters">';
            }
            ?>
        
        </a>
    </div>

    <div class="titulo">
        DRIVECRAFTERS
    </div>

    <nav id="nav" class="">

    <ul>
        <li><a href="alquiler.php" >ALQUILER</a></li>
        

        <?php
            $app = Aplicacion::getInstance();

            
            if ($app->esAdmin()) {
               //echo "<li><a href='gestionCitas.php' >GESTION DE CITAS</a></li>";
               echo "<li><a href='calendario.php' >GESTION DE CITAS</a></li>";
            }

            else if ($app->esMecanico()) {
                echo "<li><a href='horarioMecanico.php' >MI HORARIO</a></li>";
                
                                
            }
            else if ($app->usuarioLogueado() && !$app->esAdmin() && !$app->esMecanico()){
                echo "<li ><a href='citas.php' >CITAS</a></li>";
            }else{
                echo "<li><a href='noUsuarioAviso.php'>CITAS</a></li>";
            }

            
            if ($app->esAdmin()) {
                echo "<li><a href='tienda.php' >GESTION TIENDA</a></li>";
                
                                
            }
            else {
                echo "<li><a href='tienda.php' >TIENDA</a></li>";
            }

      

        ?>

        <li><a href="contacto.php" >CONTACTO</a></li>
        <li><?php
            if($modoOscuro){
                echo '<i id = "icono" class="fa-solid fa-sun" onclick="cambiarTema()"></i>';
            }else{
                echo '<i id = "icono" class="fa-solid fa-moon" onclick="cambiarTema()"></i>';
            }
            
            ?>
        
        </li>
        
         <?php
            if ($app->usuarioLogueado()) {
                echo "<li><a id = 'entrada' href='miCuenta.php' >MI CUENTA</a></li>";
                
                                
            } else {
                echo "<li><a id = 'entrada' href='entrar.php' >ENTRAR</a></li>";
            }

        ?>

       
        
    </ul>
    
    </nav>
    <?php
            if ($app->usuarioLogueado() && !$app->esAdmin() && !$app->esMecanico()) {
                echo '<i id="iconoCarro" onclick="location.href=\'carro.php\'" class="fa-solid fa-cart-shopping"></i>';
                                
            }
        
        ?>


    <div class="nav-responsive" onclick=" mostrarOcultarMenu()">
        <i class="fa-solid fa-bars"></i>
    </div>

</header>

