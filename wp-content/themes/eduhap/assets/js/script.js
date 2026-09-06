"use strict";

(function ($) {
  "use strict";

	/*PRELOADER JS*/
	$(window).on('load', function() { 
		$('.status').fadeOut();
		$('.preloader').delay(350).fadeOut('slow'); 
	});		
	
	// YouTubePopUp		
	jQuery("a.video-icon").YouTubePopUp({ autoplay: 0 });
	
$(document).ready(function(){"use strict";
	
		//Scroll back to top
		
		var progressPath = document.querySelector('.progress-wrap path');
		var pathLength = progressPath.getTotalLength();
		progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
		progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
		progressPath.style.strokeDashoffset = pathLength;
		progressPath.getBoundingClientRect();
		progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';		
		var updateProgress = function () {
			var scroll = $(window).scrollTop();
			var height = $(document).height() - $(window).height();
			var progress = pathLength - (scroll * pathLength / height);
			progressPath.style.strokeDashoffset = progress;
		}
		updateProgress();
		$(window).scroll(updateProgress);	
		var offset = 50;
		var duration = 550;
		jQuery(window).on('scroll', function() {
			if (jQuery(this).scrollTop() > offset) {
				jQuery('.progress-wrap').addClass('active-progress');
			} else {
				jQuery('.progress-wrap').removeClass('active-progress');
			}
		});				
		jQuery('.progress-wrap').on('click', function(event) {
			event.preventDefault();
			jQuery('html, body').animate({scrollTop: 0}, duration);
			return false;
		})
		
		
	});
	

  $(window).scroll(function () {
    var window_top = $(window).scrollTop() + 1;

    if (window_top > 50) {
      $('.fixed-btm-top').addClass('reveal');
    } else {
      $('.fixed-btm-top').removeClass('reveal');
    }
  });
  $(window).scroll(function () {
    var window_top = $(window).scrollTop() + 1;

    if (window_top > 50) {
      $('.site-navigation ').addClass('menu_fixed animated fadeInDown');
    } else {
      $('.site-navigation').removeClass('menu_fixed animated fadeInDown');
    }
  });
  $('.testimonials-slides').owlCarousel({
    loop: true,
    dots: true,
    nav: false,
    margin: 10,
    autoplayHoverPause: true,
    autoplay: false,
    center: true,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1
      },
      576: {
        items: 1
      },
      768: {
        items: 1
      },
      1000: {
        items: 2
      },
      1200: {
        items: 3
      }
    }
  });
  $('.testimonials-slides-2').owlCarousel({
    loop: true,
    dots: true,
    nav: false,
    margin: 10,
    autoplayHoverPause: true,
    autoplay: false,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1
      },
      576: {
        items: 1
      },
      768: {
        items: 1
      },
      1000: {
        items: 1
      },
      1200: {
        items: 1
      }
    }
  });
  $('.testimonials-slides-3').owlCarousel({
    loop: true,
    dots: true,
    nav: false,
    margin: 10,
    autoplayHoverPause: true,
    autoplay: false,
    responsiveClass: true,
    // navText: [
    //     "<i class='bx bx-left-arrow-alt'></i>",
    //     "<i class='bx bx-right-arrow-alt'></i>"
    // ],
    responsive: {
      0: {
        items: 1
      },
      576: {
        items: 1
      },
      768: {
        items: 1
      },
      1000: {
        items: 2
      },
      1200: {
        items: 2
      }
    }
  }); // Counter

  $('.counter').counterUp({
    delay: 10,
    time: 1000
  });
  $('.team-slider').owlCarousel({
    loop: true,
    nav: false,
    dots: true,
    autoplayHoverPause: true,
    autoplay: false,
    navRewind: false,
    margin: 30,
    navText: ["<i class='bx bx-left-arrow-alt'></i>", "<i class='bx bx-right-arrow-alt'></i>"],
    responsive: {
      0: {
        items: 1
      },
      576: {
        items: 2
      },
      768: {
        items: 2
      },
      1000: {
        items: 3
      },
      1200: {
        items: 4
      }
    }
  });
  /* ---------------------------------------------
         course filtering
         --------------------------------------------- */

  var $course = $('.course-gallery');

  if ($.fn.imagesLoaded && $course.length > 0) {
    imagesLoaded($course, function () {
      $course.isotope({
        itemSelector: '.course-item',
        filter: '*'
      });
      $(window).trigger("resize");
    });
  }

  $('.course-filter').on('click', 'a', function (e) {
    e.preventDefault();
    $(this).parent().addClass('active').siblings().removeClass('active');
    var filterValue = $(this).attr('data-filter');
    $course.isotope({
      filter: filterValue
    });
  });
  /* ----------------------------------------------------------- */

  /*  Map
  /* ----------------------------------------------------------- */

  var map;

  function initialize() {
    var mapOptions = {
      zoom: 13,
      center: new google.maps.LatLng(50.97797382271958, -114.107718560791) // styles: style_array_here

    };
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  }

  var google_map_canvas = $('#map-canvas');

  if (google_map_canvas.length) {
    google.maps.event.addDomListener(window, 'load', initialize);
  }
})(jQuery);