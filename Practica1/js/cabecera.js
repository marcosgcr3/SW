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
    location.reload();

}
function cambiarCSS(){
    var tema =  document.getElementById('estilo').getAttribute('href');
   
    if(tema === 'css/index.css'){
        document.cookie = "modoOscuro=activado";
    }
    else{
        document.cookie = "modoOscuro=desactivado";
    }
}




