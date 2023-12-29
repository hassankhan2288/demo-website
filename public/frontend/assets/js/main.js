/**
* Template Name: Yummy - v1.2.1
* Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
document.addEventListener('DOMContentLoaded', () => {
  "use strict";

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Sticky header on scroll
   */
  const selectHeader = document.querySelector('#header');
  if (selectHeader) {
    document.addEventListener('scroll', () => {
      window.scrollY > 100 ? selectHeader.classList.add('sticked') : selectHeader.classList.remove('sticked');
    });
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = document.querySelectorAll('#navbar a');

  function navbarlinksActive() {
    navbarlinks.forEach(navbarlink => {

      if (!navbarlink.hash) return;

      let section = document.querySelector(navbarlink.hash);
      if (!section) return;

      let position = window.scrollY + 200;

      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active');
      } else {
        navbarlink.classList.remove('active');
      }
    })
  }
  window.addEventListener('load', navbarlinksActive);
  document.addEventListener('scroll', navbarlinksActive);

  /**
   * Mobile nav toggle
   */
  const mobileNavShow = document.querySelector('.mobile-nav-show');
  const mobileNavHide = document.querySelector('.mobile-nav-hide');

  document.querySelectorAll('.mobile-nav-toggle').forEach(el => {
    el.addEventListener('click', function(event) {
      event.preventDefault();
      mobileNavToogle();
    })
  });

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavShow.classList.toggle('d-none');
    mobileNavHide.classList.toggle('d-none');
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navbar a').forEach(navbarlink => {

    if (!navbarlink.hash) return;

    let section = document.querySelector(navbarlink.hash);
    if (!section) return;

    navbarlink.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  const navDropdowns = document.querySelectorAll('.navbar .dropdown > a');

  navDropdowns.forEach(el => {
    el.addEventListener('click', function(event) {
      if (document.querySelector('.mobile-nav-active')) {
        event.preventDefault();
        this.classList.toggle('active');
        this.nextElementSibling.classList.toggle('dropdown-active');

        let dropDownIndicator = this.querySelector('.dropdown-indicator');
        dropDownIndicator.classList.toggle('bi-chevron-up');
        dropDownIndicator.classList.toggle('bi-chevron-down');
      }
    })
  });

  /**
   * Scroll top button
   */
  const scrollTop = document.querySelector('.scroll-top');
  if (scrollTop) {
    const togglescrollTop = function() {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
    window.addEventListener('load', togglescrollTop);
    document.addEventListener('scroll', togglescrollTop);
    scrollTop.addEventListener('click', window.scrollTo({
      top: 0,
      behavior: 'smooth'
    }));
  }

  /**
   * Initiate glightbox
   */
  // const glightbox = GLightbox({
  //   selector: '.glightbox'
  // });

  /**
   * Initiate pURE cOUNTER
   */
  // new PureCounter();

  /**
   * Hero swiper slider with 1 silde
   */

  new Swiper('.slides-hero', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 10000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 0
      },
    }
  });

  /**
   * Init swiper slider with 5 slides at once in desktop view
   */
  new Swiper('.popular-categories', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    navigation: {
      nextEl: '.categories-button-next',
      prevEl: '.categories-button-prev',
    },
    breakpoints: {
      300: {
        slidesPerView: 1,
        spaceBetween: 20
      },
      500: {
        slidesPerView: 2,
        spaceBetween: 20
      },
      800: {
        slidesPerView: 3,
        spaceBetween: 20
      },
      1200: {
        slidesPerView: 4,
        spaceBetween: 20
      },
      1500: {
        slidesPerView: 5,
        spaceBetween: 30
      }
    }
  });

  /**
   * Init swiper slider with 5 slides at once in desktop view
   */
  new Swiper('.brand-swiper', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    navigation: {
      nextEl: '.brand-button-next',
      prevEl: '.brand-button-prev',
    },
    breakpoints: {
      300: {
        slidesPerView: 2,
        spaceBetween: 20
      },
      500: {
        slidesPerView: 3,
        spaceBetween: 20
      },
      800: {
        slidesPerView: 4,
        spaceBetween: 20
      },
      1200: {
        slidesPerView: 5,
        spaceBetween: 20
      },
      1500: {
        slidesPerView: 6,
        spaceBetween: 30
      }
    }
  });

  /**
   * Init swiper slider with 5 slides at once in desktop view
   */
  new Swiper('.new-product-swiper', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    navigation: {
      nextEl: '.brand-button-next',
      prevEl: '.brand-button-prev',
    },
    breakpoints: {
      300: {
        slidesPerView: 1,
        spaceBetween: 20
      },
      500: {
        slidesPerView: 1,
        spaceBetween: 20
      },
      800: {
        slidesPerView: 2,
        spaceBetween: 20
      },
      1200: {
        slidesPerView: 5,
        spaceBetween: 5
      },
      1500: {
        slidesPerView: 5,
        spaceBetween: 5
      }
    }
  });

  /**
   * Related product slider with 5 slides at once in desktop view
   */
  new Swiper('.single-product', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    navigation: {
      nextEl: '.single-button-next',
      prevEl: '.single-button-prev',
    },
    breakpoints: {
      300: {
        slidesPerView: 1,
        spaceBetween: 20
      },
      500: {
        slidesPerView: 2,
        spaceBetween: 20
      },
      800: {
        slidesPerView: 3,
        spaceBetween: 20
      },
      1200: {
        slidesPerView: 4,
        spaceBetween: 20
      },
      1500: {
        slidesPerView: 5,
        spaceBetween: 30
      }
    }
  });
  // /**
  //  * Product thumbnail slider with 6 silde
  //  */

  var swiper = new Swiper(".thumbnail-swiper", {
    loop: false,
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
  });

  /**
   * Product gallery slider with 1 silde
   */
  var swiper2 = new Swiper(".product-gallery", {
    loop: false,
    spaceBetween: 10,
    thumbs: {
      swiper: swiper,
    },
  });

  $(document).ready(function(){
    var catLength = $('#category-menu').children().length;
    if(catLength > 10) $('#category-menu').children().slice(10).hide();
    $('#show-toggle').on('click', function(){
      $(this).text() == 'Show more' ? $(this).text('Show less') : $(this).text('Show more');
      $('#category-menu').children().slice(10).toggle();
    })
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
            $('.avatar-preview').css('border-color','red');
        }
        reader.readAsDataURL(input.files[0]);
    }
  }
  $("#imageUpload").change(function() {
      readURL(this);
  });
  

});
