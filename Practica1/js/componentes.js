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
    cambiarImagen();
    cambiarIconoTema();
}
function cambiarCSS(){
    var tema =  document.getElementById('estilo').getAttribute('href');
    if(tema === 'css/index.css'){
        document.getElementById('estilo').setAttribute('href','css/indexNight.css');
        
    }
    else{
        document.getElementById('estilo').setAttribute('href','css/index.css');
       
    }
}


function cambiarImagen() {
    var logo = document.getElementById('logoPrincipal');
    var imagen = document.getElementById('imagenPrincipal');
    // Cambiar la imagen actual por otra imagen
    if (logo.src.endsWith('img/LogoFondo.png')) {
        logo.src = 'img/LogoFondoInvertido.png';
        imagen.src = 'img/LogoFondoInvertido.png';
    } else {
        logo.src = 'img/LogoFondo.png';
        imagen.src = 'img/LogoFondo.png';
    }
}

function cambiarIconoTema(){
  var icono = document.getElementById('icono').className;
  if(icono === 'fa-solid fa-moon'){
    document.getElementById('icono').className = 'fa-solid fa-sun';
  }else{
    document.getElementById('icono').className = 'fa-solid fa-moon';
  }


}