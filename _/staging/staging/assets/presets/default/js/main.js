/*============== Main Js Start ========*/

(function ($) {
  "use strict";

  /*============== Header Hide Click On Body Js Start ========*/
  $(".navbar-toggler.header-button").on("click", function () {
    if ($(".body-overlay").hasClass("show")) {
      $(".body-overlay").removeClass("show");
    } else {
      $(".body-overlay").addClass("show");
    }
  });
  $(".body-overlay").on("click", function () {
    $(".header-button").trigger("click");
  });
  /* ==========================================
  *     Start Document Ready function
  ==========================================*/
  $(document).ready(function () {
    "use strict";
    /*================== Password Show Hide Js Start ==========*/
    $(".toggle-password").on("click", function () {
      $(this).toggleClass(" fa-eye-slash");
      var input = $($(this).attr("id"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    /*============** Mgnific Popup **============*/
    $(".image-popup").magnificPopup({
      type: "image",
      gallery: {
        enabled: true,
      },
    });

    $(".popup_video").magnificPopup({
      type: "iframe",
    });

    /* ========================= Latest Slider Js Start ===============*/
    $(".category-slider").slick({
      slidesToShow: 6,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 1000,
      pauseOnHover: true,
      speed: 2000,
      dots: false,
      arrows: false,
      prevArrow:
        '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
      nextArrow:
        '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
      responsive: [
        {
          breakpoint: 1199,
          settings: {
            slidesToShow: 6,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 4,
          },
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 586,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 1,
          },
        },
      ],
    });

    $(".testimonial-slider").slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 1000,
      pauseOnHover: true,
      speed: 2000,
      dots: false,
      arrows: false,
      prevArrow:
        '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
      nextArrow:
        '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
      responsive: [
        {
          breakpoint: 1199,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 1,
          },
        },
      ],
    });

    $(".slider-top").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: ".slider-bottom",
    });
    $(".slider-bottom").slick({
      prevArrow: "",
      nextArrow: "",
      slidesToShow: 6,
      slidesToScroll: 1,
      asNavFor: ".slider-top",
      dots: true,
      focusOnSelect: true,
    });

    $("a[data-slide]").on('click', function (e) {
      e.preventDefault();
      var slideno = $(this).data("slide");
      $(".slider-nav").slick("slickGoTo", slideno - 1);
    });

    /*======================= Mouse hover Js Start ============*/
    $(".mousehover-item").on("mouseover", function () {
      $(".mousehover-item").removeClass("active");
      $(this).addClass("active");
    });

    /*================== Sidebar Menu Js Start =============== */
    // Sidebar Dropdown Menu Start
    $(".has-dropdown > a").on('click', function () {
      $(".sidebar-submenu").slideUp(200);
      if ($(this).parent().hasClass("active")) {
        $(".has-dropdown").removeClass("active");
        $(this).parent().removeClass("active");
      } else {
        $(".has-dropdown").removeClass("active");
        $(this).next(".sidebar-submenu").slideDown(200);
        $(this).parent().addClass("active");
      }
    });

    /*==================== Sidebar Icon & Overlay js ===============*/
    $(".dashboard-body__bar-icon").on("click", function () {
      $(".sidebar-menu").addClass("show-sidebar");
      $(".sidebar-overlay").addClass("show");
    });
    $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
      $(".sidebar-menu").removeClass("show-sidebar");
      $(".sidebar-overlay").removeClass("show");
    });

    /*=================== Nice Select Start Js ==================*/
    // $('select').niceSelect();

    /*================= Increament & Decreament Js Start ======*/
    const productQty = $(".product-qty");
    productQty.each(function () {
      const qtyIncrement = $(this).find(".product-qty__increment");
      const qtyDecrement = $(this).find(".product-qty__decrement");
      let qtyValue = $(this).find(".product-qty__value");
      qtyIncrement.on("click", function () {
        var oldValue = parseFloat(qtyValue.val());
        var newVal = oldValue + 1;
        qtyValue.val(newVal).trigger("change");
      });
      qtyDecrement.on("click", function () {
        var oldValue = parseFloat(qtyValue.val());
        if (oldValue <= 0) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        qtyValue.val(newVal).trigger("change");
      });
    });

    /*======================= Event Details Like Js Start =======*/
    $(".hit-like").each(function () {
      $(this).on(
        click(function () {
          $(this).toggleClass("liked");
        })
      );
    });

    /* ========================= Odometer Counter Js Start ========== */
    $(".counterup-item").each(function () {
      $(this).isInViewport(function (status) {
        if (status === "entered") {
          for (
            var i = 0;
            i < document.querySelectorAll(".odometer").length;
            i++
          ) {
            var el = document.querySelectorAll(".odometer")[i];
            el.innerHTML = el.getAttribute("data-odometer-final");
          }
        }
      });
    });

    /* =================== User Profile Upload Photo Js Start ========== */
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#imagePreview").css(
            "background-image",
            "url(" + e.target.result + ")"
          );
          $("#imagePreview").hide();
          $("#imagePreview").fadeIn(650);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#imageUpload").change(function () {
      readURL(this);
    });
  });
  /*==========================================
  *      End Document Ready function
  // ==========================================*/

  /*========================= Preloader Js Start =====================*/
  $(window).on("load", function () {
    $(".preloader").fadeOut();
  });

  /*========================= Header Sticky Js Start ==============*/
  $(window).on("scroll", function () {
    if ($(window).scrollTop() >= 300) {
      $(".header").addClass("fixed-header");
    } else {
      $(".header").removeClass("fixed-header");
    }
  });

  $(window).on("scroll", function () {
    if ($(window).scrollTop() >= 300) {
      $(".header-two").addClass("fixed-header");
    } else {
      $(".header-two").removeClass("fixed-header");
    }
  });

  /*============================ Scroll To Top Icon Js Start =========*/
  var btn = $(".scroll-top");

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass("show");
    } else {
      btn.removeClass("show");
    }
  });

  btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
  });

  //Create Background Image
  (function background() {
    let img = $(".bg-img");
    img.css("background-image", function () {
      var bg = "url(" + $(this).data("background") + ")";
      return bg;
    });
  })();

  //ad Image Hide
  $(".add-icon-wrap").on("click", function () {
    $(this).parent(".ad-area").hide();
  });

  // sidebar
  $(".sidebar-menu-item > a").on("click", function () {
    var element = $(this).parent("li");
    if (element.hasClass("active")) {
      element.removeClass("active");
      element.children("ul").slideUp(500);
    } else {
      element.siblings("li").removeClass("active");
      element.addClass("active");
      element.siblings("li").find("ul").slideUp(500);
      element.children("ul").slideDown(500);
    }
  });

  //sidebar Menu
  $(document).on("click", ".navbar__expand", function () {
    $(".sidebar").toggleClass("active");
    $(".navbar-wrapper").toggleClass("active");
    $(".body-wrapper").toggleClass("active");
  });

  // Mobile Menu
  $(".sidebar-mobile-menu").on("click", function () {
    $(".sidebar__menu").slideToggle();
  });

  /*================== Password Show Hide Js ==========*/
  $(".toggle-password-change").on('click', function () {
    var targetId = $(this).data("target");
    var target = $("#" + targetId);
    var icon = $(this);
    if (target.attr("type") === "password") {
      target.attr("type", "text");
      icon.removeClass("fa-eye-slash");
      icon.addClass("fa-eye");
    } else {
      target.attr("type", "password");
      icon.removeClass("fa-eye");
      icon.addClass("fa-eye-slash");
    }
  });
  
})(jQuery);



function proPicURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var preview = $(input).parents(".thumb").find(".profilePicPreview");
      $(preview).css("background-image", "url(" + e.target.result + ")");
      $(preview).addClass("has-image");
      $(preview).hide();
      $(preview).fadeIn(650);
    };
    reader.readAsDataURL(input.files[0]);
  }
}
$(".profilePicUpload").on("change", function () {
  proPicURL(this);
});

$(".remove-image").on("click", function () {
  $(this).parents(".profilePicPreview").css("background-image", "none");
  $(this).parents(".profilePicPreview").removeClass("has-image");
  $(this).parents(".thumb").find("input[type=file]").val("");
});

$("form").on("change", ".file-upload-field", function () {
  $(this)
    .parent(".file-upload-wrapper")
    .attr(
      "data-text",
      $(this)
        .val()
        .replace(/.*(\/|\\)/, "")
    );
});

var inputElements = $("input,select,textarea");

$.each(inputElements, function (index, element) {
  element = $(element);
  if (!element.hasClass("profilePicUpload") && !element.attr("id")) {
    element
      .closest(".form-group")
      .find("label")
      .attr("for", element.attr("name"));
    element.attr("id", element.attr("name"));
  }
});
