fetch('./componentes/header.html')

  .then(response => response.text())
  .then(data => {
    document.querySelector('header').innerHTML = data

  })
  .catch

  function cambiarTema(){
    cambiarCSS();
    cambiarImagen();

}
function cambiarCSS(){
    var tema =  document.getElementById('estilo').getAttribute('href');
    if(tema === 'css/index.css' || tema === 'css/contactos.css'){
        document.getElementById('estilo').setAttribute('href','css/indexNight.css');
        document.getElementById('estilo').setAttribute('href','css/contactosNight.css');
    }
    else{
        document.getElementById('estilo').setAttribute('href','css/index.css');
        document.getElementById('estilo').setAttribute('href','css/contactos.css');
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