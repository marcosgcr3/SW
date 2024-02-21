
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
        <li><a href="ALQUILER.php" >ALQUILER</a></li>
        

        <?php


            
            if(isset($_SESSION['esMecanico'])){
                echo "<li><a href='horarioMecanico.php' >HORARIO</a></li>";

            }else if (isset($_SESSION['esAdmin'])) {
                echo "<li><a href='gestionCitas.php' >GESTION CITAS</a></li>";
                
                                
            }
            
            else {
                echo "<li><a href='citas.php' >CITAS</a></li>";
            }

            
            if (isset($_SESSION['esAdmin'])) {
                echo "<li><a href='gestionTienda.php' >GESTION TIENDA</a></li>";
                
                                
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
            if (isset($_SESSION['login'])) {
                echo "<li><a id = 'entrada' href='miCuenta.php' >MI CUENTA</a></li>";
                
                                
            } else {
                echo "<li><a id = 'entrada' href='entrar.php' >ENTRAR</a></li>";
            }

            ?>
        
        
        
    </ul>
    </nav>


    <div class="nav-responsive" onclick=" mostrarOcultarMenu()">
        <i class="fa-solid fa-bars"></i>
    </div>

</header>
