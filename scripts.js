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
    breakpoints: {
      // When screen width is >= 0px (small devices)
      0: {
        slidesPerView: 1,
      },
      // When screen width is >= 768px (tablets)
      768: {
        slidesPerView: 2,
      },
      // When screen width is >= 1024px (desktops)
      1024: {
        slidesPerView: 3,
      }}
  });
});

let items = document.querySelectorAll('.slider .list .item');
let next = document.getElementById('next');
let prev = document.getElementById('prev');
let thumbnails = document.querySelectorAll('.thumbnail .item');

// config param
let countItem = items.length;
let itemActive = 0;
// event next click
next.onclick = function(){
    itemActive = itemActive + 1;
    if(itemActive >= countItem){
        itemActive = 0;
    }
    showSlider();
}
//event prev click
prev.onclick = function(){
    itemActive = itemActive - 1;
    if(itemActive < 0){
        itemActive = countItem - 1;
    }
    showSlider();
}
// auto run slider
let refreshInterval = setInterval(() => {
    next.click();
}, 6000)
function showSlider(){
    // remove item active old
    let itemActiveOld = document.querySelector('.slider .list .item.active');
    let thumbnailActiveOld = document.querySelector('.thumbnail .item.active');
    itemActiveOld.classList.remove('active');
    thumbnailActiveOld.classList.remove('active');

    // active new item
    items[itemActive].classList.add('active');
    thumbnails[itemActive].classList.add('active');
    setPositionThumbnail();

    // clear auto time run slider
    clearInterval(refreshInterval);
    refreshInterval = setInterval(() => {
        next.click();
    }, 6000)
}
function setPositionThumbnail () {
    let thumbnailActive = document.querySelector('.thumbnail .item.active');
    let rect = thumbnailActive.getBoundingClientRect();
    if (rect.left < 0 || rect.right > window.innerWidth) {
        thumbnailActive.scrollIntoView({ behavior: 'smooth', inline: 'nearest' });
    }
}

// click thumbnail
thumbnails.forEach((thumbnail, index) => {
    thumbnail.addEventListener('click', () => {
        itemActive = index;
        showSlider();
    })
})

//Scroll Animation 
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('in-view');
    }
  });
}, {
  threshold: 0.2 // adjust based on when you want it to trigger
});

document.querySelectorAll('.cont-sect').forEach(el => {
  observer.observe(el);
});