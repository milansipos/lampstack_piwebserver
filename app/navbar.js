function togglemenu() {
    var box = document.getElementById("navi2");
    var buttons = Array.from(document.getElementsByClassName("navbutton"));
    var toggle = document.getElementById("toggle");
    if(box.style.maxWidth === "40px") {
        box.style.maxWidth = "650px";
        setTimeout(() => {
            buttons.forEach(button => {
                button.classList.add("show");  // Add the 'show' class to buttons after 1 second
            });
        }, 1600);
    } else {
        box.style.maxWidth = "40px";
        buttons.forEach(element => {
            element.classList.remove("show");
        })
    }
}