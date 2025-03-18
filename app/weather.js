function night() {
    var currentHour = new Date().getHours();
    var body = document.body;
    var img = document.getElementById("img");
    if(currentHour < 6 || currentHour >= 18) {
        body.classList.add("night");
        img.src = "../img/moon.png";
        img.style.width = "150px";
        img.style.height = "auto";
        img.style.marginBottom = "40px";
        img.style.marginLeft = "20px";
    } else {
        body.classList.remove("night");
        img.src = "../img/sun.png";
        img.style.marginBottom = "0px";
        img.style.marginLeft = "0px";
        img.style.width = "200px";
        img.style.height = "200px";

    }
}

window.onload = night;