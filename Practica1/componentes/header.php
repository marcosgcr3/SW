<header>
    <div class="logo">
        <a href="index.php" title="Home">
        <?php
        
            if ($modoOscuro) {
                echo '<img src="img/LogoFondoInvertido.png" id="imagenPrincipal" alt="centrado">';
            }else{
                echo '<img src="img/LogoFondo.png" id="imagenPrincipal" alt="centrado">';}
        ?>
        </a>
    </div>
    <nav id="nav" class="">
    <ul>
        <li><a href="bocetos.php" >BOCETOS</a></li>
        <li><a href="detalles.php">DETALLES</a></li>
        <li><a href="planificacion.php" >PLANIFICACION</a></li>
        <li><a href="miembros.php" >MIEMBROS</a></li>
        <li><a href="contacto.php" >CONTACTO</a></li>
        <li><?php
            if($modoOscuro){
                echo '<i id = "icono" class="fa-solid fa-sun" onclick="cambiarTema()"></i>';
            }else{
                echo '<i id = "icono" class="fa-solid fa-moon" onclick="cambiarTema()"></i>';
            }
            
            ?></li>
    </ul>
    </nav>


    <div class="nav-responsive" onclick=" mostrarOcultarMenu()">
        <i class="fa-solid fa-bars"></i>
    </div>

</header>

