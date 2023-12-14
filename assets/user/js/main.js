(function ($) {
  "use strict";

  // light box
  $(".image-popup-vertical-fit").magnificPopup({
    type: "image",
    closeOnContentClick: true,
    mainClass: "mfp-img-mobile",
    image: {
      verticalFit: true,
    },
  });

  // stikcy js
  $("#sticker").sticky({
    topSpacing: 0,
  });

  //mean menu
  $(".main-menu").meanmenu({
    meanMenuContainer: ".mobile-menu",
    meanScreenWidth: "992",
  });

  jQuery(window).on("load", function () {
    jQuery(".loader").fadeOut(1000);
  });
})(jQuery);
