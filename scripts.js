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

///Swiper
document.addEventListener("DOMContentLoaded", function () {
  const swiper = new Swiper('.swiper', {
    slidesPerView: 3,       // Show 3 slides at once
    spaceBetween: 10,       // Spacing between slides
    loop: true,             // Loop infinitely
    autoplay: {
      delay: 6000,          // Delay between transitions (in ms)
      disableOnInteraction: false, // Keep autoplay running even after interactions
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    scrollbar: {
      el: '.swiper-scrollbar',
      draggable: true,
    },
  });
});
