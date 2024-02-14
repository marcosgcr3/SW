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



