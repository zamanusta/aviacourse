// mobile Slide menu jquery
jQuery(".menu-toggle").click(function(){
	jQuery(".mobile-menu").toggleClass("active");
	jQuery("body").toggleClass("menu-change");
	jQuery(".overlay-main").toggleClass("active");
});
jQuery(".overlay-main").click(function(){
	jQuery(".mobile-menu").removeClass("active");
	jQuery("body").removeClass("menu-change");
	jQuery(".overlay-main").removeClass("active");
});
jQuery(".top-close-menu").click(function(){
	jQuery(".mobile-menu").removeClass("active");
	jQuery("body").removeClass("menu-change");
	jQuery(".overlay-main").removeClass("active");
});

// mobile menu jquery

jQuery('.mobile-menu ul li').each(function(){
	jQuery(this).children('ul').before('<span class="sub"><i class="fa fa-angle-down" aria-hidden="true"></i></span>');    
});
jQuery('.mobile-menu ul li .sub').click(function(e) {
	jQuery(this).next('ul').slideToggle();

	jQuery(this).toggleClass('submenu-hide');

});