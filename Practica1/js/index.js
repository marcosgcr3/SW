let menuVisible = false;

function modoMenu(){
    if(menuVisible){
        document.getElementById("nav").classList= "";
        menuVisible = false;
    }else{
        document.getElementById("nav").classList= "responsive";
        menuVisible = true;
    }
}