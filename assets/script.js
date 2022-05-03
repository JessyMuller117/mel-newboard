
var menuPrincipal = document.querySelector("#menu-principal");
var btnActionClose = document.querySelector(".btn-close-menu");
var btnActionOpen = document.querySelector(".btn-open-menu");

btnActionClose.addEventListener('click', ()=>{
menuPrincipal.style.left = "-295px";
menuPrincipal.style.transition = "all ease .4s";
btnActionOpen.style.opacity =  "1";
btnActionOpen.style.visibility =  "visible";


});

btnActionOpen.addEventListener('click', ()=>{
menuPrincipal.style.left = "0";
btnActionOpen.style.visibility =  "hidden";
btnActionOpen.style.opacity =  "0";

menuPrincipal.style.transition = "all ease .4s";
});


// script pour associer un utilisateur et son entreprise

// script pour les grades

// un grade c'est un nom une recompense un pourcentage

//Date du jour
// var date = new Date();
// var options = {weekday: "long", year: "numeric", month: "long", day: "2-digit"};
// alert(date.toLocaleDateString("fr-FR", options));     