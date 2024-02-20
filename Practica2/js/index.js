function cambiarImagen() {
    
    var imagen = document.getElementById('imagenPrincipal');
    //if (imagen.src==('img/LogoFondo.png'))
    if (imagen.src.endsWith('img/LogoFondo.png')) {
        
        imagen.src = 'img/LogoFondoInvertido.png';
    } else {
       
        imagen.src = 'img/LogoFondo.png';
    }
}


