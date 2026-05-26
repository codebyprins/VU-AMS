document.querySelectorAll('.swiper').forEach((slider) => {
  new Swiper(slider, {
    loop: true,

    autoplay: {
      delay: 8000,
      disableOnInteraction: false,
    },

    pagination: {
      el: slider.querySelector('.swiper-pagination'),
      clickable: true,
    },

    navigation: {
      nextEl: slider.querySelector('.swiper-button-next'),
      prevEl: slider.querySelector('.swiper-button-prev'),
    },
  });

});