

function checkOrientation() {
  // Check if the device has a screen width typical of mobile devices
  if (window.innerWidth <= 991) {  // 768px is the breakpoint for tablets/mobiles
    if (window.innerHeight < window.innerWidth) {
      // Phone is in landscape mode
      document.body.classList.add('landscape');
    } else {
      // Phone is in portrait mode
      document.body.classList.remove('landscape');
    }
  } else {
    // Optionally, remove the class for non-mobile devices, if necessary
    document.body.classList.remove('landscape');
  }
}

// Check on load
window.addEventListener('load', checkOrientation);

// Check when the orientation changes (on resize)
window.addEventListener('resize', checkOrientation);


document.addEventListener("DOMContentLoaded", function () {
  let currentUrl = window.location.href;
  let menuItems = document.querySelectorAll(".menu_link .menu_items");

  menuItems.forEach(function (item) {
    let link = item.querySelector("a");
    if (link && link.href === currentUrl) {
      document.querySelector(".menu_items.active")?.classList.remove("active"); // Remove previous active class
      item.classList.add("active");
    }
  });
});

$(document).ready(function () {
  var $container = $(".container");
  var $instagramFeeds = $(".instagram_feeds");
  var $blogSection = $(".new_blog_main");
  var $location_slider = $(".location_slider_items");
  var $history_slider = $(".history_slider");

  if (
    document.querySelector(".custom_video_pause_item") &&
    document.getElementById("videoIframe")
  ) {
    document
      .querySelector(".custom_video_pause_item")
      .addEventListener("click", function () {
        var iframe = document.getElementById("videoIframe");
        var iframeSrc = iframe.src;
        var image = this.querySelector("img");

        if (iframeSrc.includes("autoplay=1")) {
          iframe.src = iframeSrc.replace("autoplay=1", "autoplay=0");
          image.src = "/themes/food/assets/Images/play.svg";
        } else {
          iframe.src = iframeSrc.replace("autoplay=0", "autoplay=1");
          image.src = "/themes/food/assets/Images/pause.png";
        }
      });
  }

  $(document).ready(function () {
    var isRTL = $("body").hasClass("ar") && $("body").attr("dir") === "rtl";
  
    // Banner Main Slider Initialization
    $("#banner_main_slider .owl-carousel").owlCarousel({
      loop: false,
      margin: 10,
      autoplay: false,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      nav: false,
      dots: false,
      items: 1,
      video: true,
      lazyLoad: true,
      rtl: isRTL, // RTL support
    });
  
    // Instagram Feeds Carousel Initialization
    $(".instagram_feeds .owl-carousel").owlCarousel({
      loop: false,
      margin: 10,
      nav: false,
      dots: false,
      rtl: isRTL, // RTL support
      responsive: {
        0: { items: 2, stagePadding: 50, margin: 5 },
        600: { items: 3, stagePadding: 50, margin: 10 },
        1000: { items: 4.6 },
      },
    });
  
    $(".new_blog_main .owl-carousel").owlCarousel({
      loop: false,
      margin: 37,
      nav: false,
      dots: true,
      dotsEach: true,
      rtl: isRTL, // RTL support
      responsive: {
        0: { items: 1, stagePadding: 50, margin: 22 },
        600: { items: 2, stagePadding: 50, margin: 22 },
        1000: { items: 3 },
      },
    });
  
    $(".our_team_slider .owl-carousel").owlCarousel({
      loop: false,
      margin: 37,
      nav: false,
      dots: true,
      dotsEach: true,
      rtl: isRTL, // RTL support
      responsive: {
        0: { items: 1, stagePadding: 30, margin: 22 },
        600: { items: 2 },
        1000: { items: 3 },
        1366: { items: 4 },
      },
    });
  
    $(".custom-prev-btn12").click(function () {
      $(".our_team_slider .owl-carousel").trigger("prev.owl.carousel");
    });
  
    $(".custom-next-btn12").click(function () {
      $(".our_team_slider .owl-carousel").trigger("next.owl.carousel");
    });
  
    $(".our_award_slider .owl-carousel").owlCarousel({
      loop: false,
      margin: 30,
      nav: false,
      dots: false,
      dotsEach: true,
      rtl: isRTL, // RTL support
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 3 },
      },
    });
  
    $(".custom-prev-btn11").click(function () {
      $(".our_award_slider .owl-carousel").trigger("prev.owl.carousel");
    });
  
    $(".custom-next-btn11").click(function () {
      $(".our_award_slider .owl-carousel").trigger("next.owl.carousel");
    });
  
    $(".our_menu_main_item .owl-carousel").owlCarousel({
      loop: false,
      margin: 30,
      nav: false,
      dots: false,
      dotsEach: true,
      rtl: isRTL, // RTL support
      responsive: {
        0: { items: 1, stagePadding: 20, margin: 22 },
        600: { items: 2 },
        1000: { items: 3 },
      },
    });
  
    $(".custom-prev-btn_1").click(function () {
      $(".our_menu_main_item .owl-carousel").trigger("prev.owl.carousel");
    });
  
    $(".custom-next-btn_1").click(function () {
      $(".our_menu_main_item .owl-carousel").trigger("next.owl.carousel");
    });
  
    $(".more_brands_items_main .owl-carousel").owlCarousel({
      loop: false,
      margin: 30,
      nav: false,
      dots: false,
      dotsEach: true,
      rtl: isRTL, // RTL support
      responsive: {
        0: { items: 1, stagePadding: 50, margin: 22 },
        600: { items: 2 },
        1000: { items: 4 },
      },
    });
  
    $(".custom-prev-btn_2").click(function () {
      $(".more_brands_items_main .owl-carousel").trigger("prev.owl.carousel");
    });
  
    $(".custom-next-btn_2").click(function () {
      $(".more_brands_items_main .owl-carousel").trigger("next.owl.carousel");
    });
  
    $(".news_blog_details_listing_main .owl-carousel").owlCarousel({
      loop: false,
      margin: 30,
      nav: false,
      dots: false,
      dotsEach: true,
      rtl: isRTL, // RTL support
      responsive: {
        0: { items: 1, stagePadding: 50, margin: 22 },
        600: { items: 2, stagePadding: 50, margin: 22 },
        1000: { items: 3 },
      },
    });
  
    $(".custom-prev-btn_3").click(function () {
      $(".news_blog_details_listing_main .owl-carousel").trigger("prev.owl.carousel");
    });
  
    $(".custom-next-btn_3").click(function () {
      $(".news_blog_details_listing_main .owl-carousel").trigger("next.owl.carousel");
    });
  
    // Function to hide/show the navigation buttons based on the number of items
    function toggleCarouselNavButtons() {
      var windowWidth = $(window).width();
  
      if (windowWidth <= 1024) {
        $(".custom-prev-btn12, .custom-next-btn12").show();
        $(".custom-prev-btn11, .custom-next-btn11").show();
        $(".custom-prev-btn_1, .custom-next-btn_1").show();
        $(".custom-prev-btn_2, .custom-next-btn_2").show();
        $(".custom-prev-btn_3, .custom-next-btn_3").show();
        return;
      }
  
      // Our Team Slider
      if ($(".our_team_slider .owl-carousel .owl-item").length <= $(".our_team_slider .owl-carousel").data("owl.carousel").options.responsive[1366].items) {
        $(".custom-prev-btn12, .custom-next-btn12").hide();
      } else {
        $(".custom-prev-btn12, .custom-next-btn12").show();
      }
  
      // Our Award Slider
      if ($(".our_award_slider .owl-carousel .owl-item").length <= $(".our_award_slider .owl-carousel").data("owl.carousel").options.responsive[1000].items) {
        $(".custom-prev-btn11, .custom-next-btn11").hide();
      } else {
        $(".custom-prev-btn11, .custom-next-btn11").show();
      }
  
      // Our Menu Main Item Slider
      if ($(".our_menu_main_item .owl-carousel .owl-item").length <= $(".our_menu_main_item .owl-carousel").data("owl.carousel").options.responsive[1000].items) {
        $(".custom-prev-btn_1, .custom-next-btn_1").hide();
      } else {
        $(".custom-prev-btn_1, .custom-next-btn_1").show();
      }
  
      // More Brands Items Main Slider
      if ($(".more_brands_items_main .owl-carousel .owl-item").length <= $(".more_brands_items_main .owl-carousel").data("owl.carousel").options.responsive[1000].items) {
        $(".custom-prev-btn_2, .custom-next-btn_2").hide();
      } else {
        $(".custom-prev-btn_2, .custom-next-btn_2").show();
      }
  
      // News Blog Details Listing Main Slider
      if ($(".news_blog_details_listing_main .owl-carousel .owl-item").length <= $(".news_blog_details_listing_main .owl-carousel").data("owl.carousel").options.responsive[1000].items) {
        $(".custom-prev-btn_3, .custom-next-btn_3").hide();
      } else {
        $(".custom-prev-btn_3, .custom-next-btn_3").show();
      }
    }
  
    toggleCarouselNavButtons();
    $(window).resize(toggleCarouselNavButtons);
  });
  
  // Adjust Margins for Centered Elements
  function adjustMargins() {
    if (
        $container.length &&
        ($instagramFeeds.length || $blogSection.length || $history_slider.length)
    ) {
        var containerWidth = $container.outerWidth();
        var screenWidth = $(window).width();
        var isRTL = $("body").hasClass("ar") && $("body").attr("dir") === "rtl";

        // Function to adjust margin for elements
        function setElementMargin(element) {
            if (screenWidth > containerWidth) {
                var margin = (screenWidth - containerWidth) / 2 + 12;
                element.css(isRTL ? "margin-right" : "margin-left", margin + "px");
            } else {
                element.css(isRTL ? "margin-right" : "margin-left", "12px");
            }
        }

        function setHistoryMargin(element) {
            if (screenWidth > containerWidth) {
                var margin = (screenWidth - containerWidth) / 2 + 12;
                element.css(isRTL ? "padding-right" : "padding-left", margin + "px");
            } else {
                element.css(isRTL ? "padding-right" : "padding-left", "12px");
            }
        }

        function setLocationMargin(element) {
            if (screenWidth > containerWidth) {
                var margin = (screenWidth - containerWidth) / 2 + 12;
                element.css(isRTL ? "left" : "right", margin + "px");
            } else {
                element.css(isRTL ? "left" : "right", "12px");
            }
        }

        setElementMargin($instagramFeeds);
        setElementMargin($blogSection);
        setLocationMargin($location_slider);
        setHistoryMargin($history_slider);
    }
}

// Initial margin adjustment
adjustMargins();

// Recalculate margins on window resize
$(window).resize(function () {
    adjustMargins();
});

 // Counter Animation on Scroll
function animateCounter($element) {
  const targetValue = $element.attr("data-target");
  let target = parseInt(targetValue.replace('+', ''), 10);  // Remove + if it exists
  const hasPlusSign = targetValue.includes('+');  // Check if there's a plus sign
  
  const duration = 2000;
  const stepTime = 10;
  const steps = Math.ceil(duration / stepTime);
  const increment = target / steps;

  let current = 0;
  const interval = setInterval(() => {
    current += increment;
    if (current >= target) {
      $element.text(target + (hasPlusSign ? '+' : ''));  // Add plus sign if needed
      clearInterval(interval);
    } else {
      $element.text(Math.ceil(current) + (hasPlusSign ? '+' : ''));  // Add plus sign if needed
    }
  }, stepTime);
}


  function isInView($element) {
    const elementTop = $element.offset().top;
    const elementBottom = elementTop + $element.outerHeight();
    const viewportTop = $(window).scrollTop();
    const viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
  }

  function checkCounters() {
    $(".counter").each(function () {
      const $this = $(this);
      if (isInView($this) && !$this.data("animated")) {
        $this.data("animated", true);
        animateCounter($this);
      }
    });
  }

  // Scroll event for counters
  $(window).on("scroll", checkCounters);
  checkCounters();

  var swiper = new Swiper("#location_slider_1", {
    slidesPerView: window.innerWidth < 380 ? 1 : (window.innerWidth <= 767 ? 1.2 : 3),
    spaceBetween: 10,
    pagination: false,
    navigation:
      window.innerWidth > 768
        ? {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          }
        : false,
    loop: false,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    direction: window.innerWidth <= 767 ? "horizontal" : "vertical",
  });

  window.addEventListener("resize", function () {
    swiper.params.slidesPerView = window.innerWidth <= 767 ? 1.2 : 3;
    swiper.changeDirection(
      window.innerWidth <= 767 ? "horizontal" : "vertical"
    );

    if (window.innerWidth <= 767) {
      swiper.navigation.destroy();
      swiper.params.navigation = false;
    } else {
      swiper.params.navigation = {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      };
      swiper.navigation.init();
    }

    swiper.update();
  });

  var swiper1 = new Swiper("#history_slider_1", {
    direction: "vertical",
    slidesPerView: 1,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      renderBullet: function (index, className) {
        // Get the year from the "date" attribute of the slide
        const slide = document.querySelectorAll(".swiper-slide")[index];
        const year = slide.getAttribute("date") || "";
        return `<span class="${className}"><span class="history_date">${year}</span></span>`;
      },
    },
    mousewheel: true,
  });

  if ($(".brands_details_breadcrumb , .black_header").length) {
    $("#header").addClass("singleheader");
  }

  let imgBoxCount = $(".sub .img-box").length - 2;

  console.log("Total .img-box count:", imgBoxCount);

  let newContent = `
      <div class="transparent-box">
        <div class="caption">+${imgBoxCount}</div>
      </div>
    `;

  $(".sub .img-box:nth-child(3) .glightbox").append(newContent);

  let updatedImgBoxCount = $(".sub .img-box").length - 2;
  console.log("Updated .img-box count:", updatedImgBoxCount);
});

document.addEventListener("DOMContentLoaded", function () {
  const lightbox = GLightbox({
    selector: ".glightbox",
    touchNavigation: true,
    loop: false,
    width: "90vw",
    height: "90vh",
  });
});

window.addEventListener("scroll", function () {
  const header = document.getElementById("header");
  if (window.scrollY > 0) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});

$(".navbar-toggler").on("click", function () {
  $(this).closest("nav").toggleClass("bg_header");
});

function adjustSwiperWidth() {
  if (window.innerWidth < 768) {
    const newWidth = window.innerWidth - 24;
    const swiperWrapper = document.querySelector(
      ".location_slider_items .swiper-wrapper"
    );
    if (swiperWrapper) {
      swiperWrapper.style.width = `${newWidth}px`;
      swiperWrapper.style.maxWidth = "100%";
    }
  } else {
    const swiperWrapper = document.querySelector(
      ".location_slider_items .swiper-wrapper"
    );
    if (swiperWrapper) {
      swiperWrapper.style.width = "";
      swiperWrapper.style.maxWidth = "";
    }
  }
}
adjustSwiperWidth();
window.addEventListener("resize", adjustSwiperWidth);


