(function ($) {
    "use strict";
    $(document).ready(function () {
        $('.blog-gallery').slick({         
          dots: false,
          arrows: true,
          nextArrow: '<button class="btn-prev"><i class="pe-7s-angle-left"></i></button>',
          prevArrow: '<button class="btn-next"><i class="pe-7s-angle-right"></i></button>',
          infinite: true,
          autoplay: false,
          autoplaySpeed: 2000,
          slidesToShow: 1,
          slidesToScroll: 1
        });
    });

})(jQuery);
// Active Cart, Search