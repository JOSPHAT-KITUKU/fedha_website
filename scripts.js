const menubtn = document.getElementById("small_devices");
const menudis = document.getElementById("nav-links_small");

function menuToggle(){
    menudis.classList.toggle("active");
}

menubtn.addEventListener("click", menuToggle);

const links = menudis.querySelectorAll("a");
links.forEach(link => {
  link.addEventListener("click", () => {
    menudis.classList.remove("active");
  });
});