currentModalPage = 0;
function changeModalPage(dir){
    currentModalPage = currentModalPage + dir;

    if(currentModalPage === 0){
        document.getElementById("owner-form").style.display = "block";
        document.getElementById("car-form").style.display = "none";
        document.getElementById("ad-form").style.display = "none";
    }

    else if(currentModalPage === 1){
        document.getElementById("owner-form").style.display = "none";
        document.getElementById("car-form").style.display = "block";
        document.getElementById("ad-form").style.display = "none";
    }

    else if(currentModalPage === 2){
        document.getElementById("owner-form").style.display = "none";
        document.getElementById("car-form").style.display = "none";
        document.getElementById("ad-form").style.display = "block";
    }
}