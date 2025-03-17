function menu_appear() {
    var button = document.getElementById("menu");
    var box = document.querySelector(".box");
    if (!button.classList.contains("show")) {
        button.classList.add("show");
        box.style.maxHeight = "150px";
    } else {
        button.classList.remove("show");
        box.style.maxHeight = "45px";
    }
}
