// Menus
$(document).ready(function() {
  $(window).scroll(function() {
    if ($(document).scrollTop() > 50) {
      $("#nav").removeClass("navbar-transparan");
      $("#nav").addClass("nav-colored");
    } else {
      $("#nav").removeClass("nav-colored");
      $("#nav").addClass("navbar-transparan");
    }

    if ($(document).scrollTop() > 600) {
      $(".gotoup").removeClass(" invisible");
    } else {
      $(".gotoup").addClass(" invisible");
    }
  });
});
// Owl Carousel alur_pendaftaran
$("#alur_pendaftaran").owlCarousel({
  loop: true,
  margin: 10,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
      nav: true,
      dots: false
    },
    700: {
      items: 2,
      nav: true,
      dots: false
    },
    1000: {
      items: 3,
      nav: true,
      dots: false
    },
    1200: {
      items: 4,
      nav: true,
      dots: false
    }
  }
});
// Owl Carousel list_madrasah
$("#list_madrasah").owlCarousel({
  loop: true,
  margin: 10,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
      nav: true,
      dots: false
    },
    700: {
      items: 2,
      nav: true,
      dots: false
    },
    1000: {
      items: 3,
      nav: true,
      dots: false
    }
  }
});
// ScrollIt
$(function() {
  $.scrollIt();
});
// Active Menus
$(function() {
  var current = window.location.href;
  $(".navbar-nav li a").each(function() {
    var $this = $(this);
    if ($this.attr("href") == current) {
      $this.parents("li").addClass("active");
    }
  });
  $(".nav li a").each(function() {
    var $this = $(this);
    if ($this.attr("href") == current) {
      $this.parents("li").addClass("active");
    }
  });
});
// Owl Carousel related_video_list
$("#related_video_list").owlCarousel({
  loop: true,
  margin: 10,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
      nav: false,
      dots: false
    },
    700: {
      items: 2,
      nav: false,
      dots: false
    },
    1000: {
      items: 3,
      nav: false,
      dots: false
    }
  }
});
// Owl Carousel related_artikel_list
$("#related_artikel_list").owlCarousel({
  loop: true,
  margin: 10,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
      nav: false,
      dots: false
    },
    700: {
      items: 2,
      nav: false,
      dots: false
    },
    1000: {
      items: 3,
      nav: false,
      dots: false
    }
  }
});
// Pagination Center
$("nav ul.pagination").ready(function() {
  $('nav ul.pagination').addClass(' justify-content-center');
});
