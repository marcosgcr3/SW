let menuVisible = false;
//Función que oculta o muestra el menu
function mostrarOcultarMenu(){
    if(menuVisible){
        document.getElementById("nav").classList.remove("responsive");
        menuVisible = false;
    }else{
        document.getElementById("nav").classList.add("responsive");
        menuVisible = true;
    }
}

 
function cambiarTema(){
    
   
    cambiarCSS(); 
    if(document.getElementsByName('Index')){
        cambiarImagen();
    }
}
function cambiarCSS(){
    var tema =  document.getElementById('estilo').getAttribute('href');
    var logo = document.getElementById('logoPrincipal');
    if(tema === 'css/index.css'){
        document.getElementById('estilo').setAttribute('href','css/indexNight.css');
        logo.src = 'img/LogoFondoInvertido.png'
        document.getElementById('icono').className = 'fa-solid fa-sun';
       
    }
    else{
        document.getElementById('estilo').setAttribute('href','css/index.css');
        logo.src = 'img/LogoFondo.png';
        document.getElementById('icono').className = 'fa-solid fa-moon';
       
    }
}
function cerrarSesion(){
    
 session_start();
 unset($_SESSION['login']);
 unset($_SESSION['nombre']);
 unset($_SESSION['esAdmin']);
 session_destroy();
}


