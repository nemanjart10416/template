var setError = (errorElementName, error) => {
    var element = document.getElementById(errorElementName + "Error");
    element.style.display = "block";
    element.innerHTML = error;
    document.getElementById(errorElementName).focus();
    document.getElementById(errorElementName).scrollIntoView({
        behavior: 'smooth',
        block: 'center'
    });
}

var removeError = (errorElementName) => {
    var element = document.getElementById(errorElementName + "Error");
    element.innerHTML = "";
    element.style.display = "none";
}

//navigacija
var navbarDropdown = document.getElementById("navbarDropdown");
var dropdownmenu = document.getElementsByClassName("dropdown-menu");
var navbartoggler = document.getElementsByClassName("navbar-toggler");
var navbarcollapse = document.getElementsByClassName("navbar-collapse");

window.addEventListener("click",(e)=>{
    if(!e.target.closest(".navbar-toggler") && !e.target.closest(".collapse")){
        navbarcollapse[0].classList.remove("show");
        navbartoggler[0].classList.add("collapsed");
    }
});

if(navbartoggler.length>0 && navbarcollapse.length>0){
    ['click'].forEach((event)=>{
        navbartoggler[0].addEventListener(event,(e)=>{
            console.log("click");
            if(e.target.classList.contains("collapsed")){
                navbarcollapse[0].classList.add("show");
                e.target.classList.remove("collapsed");
            }else{
                navbarcollapse[0].classList.remove("show");
                e.target.classList.add("collapsed");
            }
        });
    });
}