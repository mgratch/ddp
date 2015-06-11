/**
 * @author John
 */


function isTouchDevice(){
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	 	return true;
	}else{
		return false;
	}
}

function isMobile() {
	if (isTouchDevice() || $j(document).width() <= 767  ) {
		return true;
	} else {
		return false;
	}
}

function isTablet() {
	if (isTouchDevice() || ($j(document).width() <= 899 && !isMobile()) ) {
		return true;
	} else  {
		return false;
	}
}

function isDesktop() {
	if (!isTouchDevice() && $j(document).width() >= 900 ) {
		return true;
	} else {
		return false;
	}
}

function isIE8() {
	if ( $j('html').hasClass('ie8') ) {
		return true;
	} else {
		return false;
	}
}



jQuery(document).ready(function($){

	if(isTouchDevice()){
		$("body").addClass("touch-device");
	}

	$('#wrapper .events .row.main-body .single-listing .img-container img').css('opacity', 0);

	var navIsOpen = false;
	var subNavIsOpen = false;

	var scrollNav = function(){

		var scrollPos = $(document).scrollTop();
		if (scrollPos > 15 && isTouchDevice() == false ) {
			$('header').addClass('min').animate({'height': '60px'}, 0);
			$('#about-menu > .search').addClass('min');

		} else if ( scrollPos <= 15 ) {
			$('header').removeClass('min').animate({'height': '120px'}, 0);
			$('#about-menu > .search').removeClass('min');
		}
	}


	var closeNav = function(){
		$('#wrapper, header').css({'right': '0px'});
		$('#about-menu').css({'right': '-275px'});
		$('header .about span').removeClass('open');
		navIsOpen = false;
	}

	var openNav = function(){
		$('#wrapper, header').css({'right': '275px'});
		$('#about-menu').css({'right': '0px'});
		$('header .about span').addClass('open');
		navIsOpen = true;
	}


	$('header .about span').removeClass('open');


	$('#wrapper, header').css({'right': '0px'});
	$('#about-menu').css({'right': '-275px'});

	scrollNav();


	$(document).scroll(function(){

		scrollNav();
		/*
		if (navIsOpen == true && isTouchDevice() == false) {
			closeNav();
		}*/
	});

// add and remove open class to menu items in header.
	$('.menu-item-has-children > a').click(function(e) {
		e.preventDefault();

		if( $(this).parent().hasClass('open') ) {
			$(this).parent().removeClass('open');
		} else {
			$('.menu-item-has-children').removeClass('open');
			$(this).parent().addClass('open');
		}
	});

	$('header a.about').click(function(e){
		e.preventDefault();
		if (navIsOpen == false) {
			openNav();
		} else {
			closeNav();
		}

	});

	$('body').on("swiperight", function(){
		if (navIsOpen == true){
		closeNav();
		}
	});

	// responsive menus

		$('body #wrapper #wrapper-interior.interior-page .col-md-3 .left-sidebar').mouseenter(function(){
			if ($(document).width() <= 991 && isTouchDevice() == false) {
			$('body #wrapper #wrapper-interior.interior-page .col-md-3 .left-sidebar ul.sub-menu').css({'height': 'auto'}).addClass('open');
			 subNavIsOpen = true;
			}

		}).mouseleave(function(){
			if ($(document).width() <= 991  && isTouchDevice() == false) {
			$('body #wrapper #wrapper-interior.interior-page .col-md-3 .left-sidebar ul.sub-menu').css({'height': '0'});
			subNavIsOpen = false;
			}
		});

		$('body #wrapper #wrapper-interior.interior-page .col-md-3 .left-sidebar').click(function(){
			if ( isTouchDevice() && subNavIsOpen == true) {
			$('body #wrapper #wrapper-interior.interior-page .col-md-3 .left-sidebar ul.sub-menu').css({'height': '0'});
			subNavIsOpen = false;
			} else if ( isTouchDevice() && subNavIsOpen == false) {
				$('body #wrapper #wrapper-interior.interior-page .col-md-3 .left-sidebar ul.sub-menu').css({'height': 'auto'});
			 subNavIsOpen = true;
			} else {

			}
		});

		$('body #about-menu .main-menu > li.menu-item-has-children, .responsive-sidebar-nav > .responsive-item, body #about-menu .responsive-sidebar-nav .responsive-item ul.sub-menu > li.menu-item-has-children').click(function(e){
			e.stopPropagation();
			e.preventDefault();
			if ($(this).hasClass('active')) {
				$(this).children('ul').first().slideUp();
				$(this).removeClass('active');
			} else {
				$(this).children('ul').first().slideDown();
		     	$(this).addClass('active');
			}
		});

		$('body #about-menu .main-menu li.menu-item-has-children ul.sub-menu li a, body #about-menu .responsive-sidebar-nav .responsive-item ul.sub-menu li').on('click', function(e){

			if ($(this).hasClass('menu-item-has-children')) {
			e.preventDefault();
			} else {
			e.stopPropagation();
			}
		});



	$('.title-toggle').click(function(){
		$('.slideshow, .title-toggle').toggleClass('toggled');

	});


	/*
	var dropdown = new Array();
	var interval = new Array(-1, -1, -1);


	$('ul.big-three li').mouseenter(function(){
		//console.log('over');
		var id = $(this).attr('id').split('-');
		var index = id[1];
		clearTimeout(interval[index]);
		interval[index] = -1;
		dropdown[index] = $('.dropdown-menu', $(this));
		dropdown[index].addClass('over');
		dropdown[index].animate({height:'275px'}, 500);
	}).mouseleave(function(){
		//console.log('out');
		var id = $(this).attr('id').split('-');
		var index = id[1];

		dropdown[index].animate({height:'0px'}, 500);
		interval[index] = setTimeout(function(){
			dropdown[index].removeClass('over');
		}, 800);

	});
	*/

	// center event archive image
	var centerImage = function(){
		$('.events .main-content .img-container').each(function(){
			var imgWidth = $(this).find('img').width();
			imgWidth -= $(this).width();
			imgWidth /= -2;
			$(this).find('img').css({'margin-left': imgWidth, 'opacity': 0}).delay(100).fadeTo('slow', 1);

		});

	}
	centerImage();

	// property sorting
	var properties = $('.interior-page.property-listings .single-listing');

	$('.sort-listings a#sortName').click(function(e){
		e.preventDefault();
		properties.tsort({attr: 'data-name', order: 'asc'});
		$('.sort-listings a').removeClass('active');
		$(this).addClass('active');
	});

	$('.sort-listings a#sortUnits').click(function(e){
		e.preventDefault();
		properties.tsort({attr: 'data-units', order: 'desc'});
		$('.sort-listings a').removeClass('active');
		$(this).addClass('active');

	});


	var feat1_swiper, feat2_swiper, feat3_swiper, twitter_swiper;

	function enable_swipers(){
		feat1_swiper = $(".feature-article-1 .swiper-container").swiper({
			mode:'horizontal',
			loop:true,
			autoplay:5000
		});
		feat2_swiper = $(".feature-article-2 .swiper-container").swiper({
			mode:'horizontal',
			loop:true,
			autoplay:6000
		});
		feat3_swiper = $(".feature-article-3 .swiper-container").swiper({
			mode:'horizontal',
			loop:true,
			autoplay:7000
		});

		$(".feature-twitter-feed .text-box .latest-tweets > ul").addClass("swiper-wrapper");
		$(".feature-twitter-feed .text-box .latest-tweets > ul > li").addClass("swiper-slide");
		twitter_swiper = $(".feature-twitter-feed .text-box .latest-tweets").addClass("swiper-container").swiper({
			mode:'horizontal',
			loop:true,
			autoplay:7000
		});


	}
	enable_swipers();


	function toggle_markers(slug, state){
		for(var key in gmarkers){
			var marker = gmarkers[key];
			if(marker.category == slug){
				marker.setVisible(state);
			}
		}
	}

	function setup_cat_nav(){
		$(".map-container .info-overlay .links a").bind('click', function(e){
			e.preventDefault();

			var slug = $(this).attr("id");
			$(this).toggleClass("active");

			if($(this).hasClass("active")){
				toggle_markers(slug, true);
			}else{
				toggle_markers(slug, false);
			}


		});
	}

	setup_cat_nav();

	$('body.home .article-nav li').bind('click', function(e){
		e.preventDefault();
		var type = $(this).attr("id");
		//alert('events clicked');
		$( ".ajax-container.articles-content" ).animate({opacity:0},500, function(e){
			  $(".loading").removeClass("hide");
			$.get( "/events-ajax?t="+type, function( data ) {
			  $( ".ajax-container.articles-content" ).html( data );
			  $(".loading").addClass("hide");
			  $(".ajax-container.articles-content").animate({opacity:1},500);
			  enable_swipers();
			  if(type == "articles-interactive-map"){
			  	setup_cat_nav();
			  }

			  //alert( "Load was performed." );
			});
		});

		$('body.home .article-nav li').removeClass("selected");
		$(this).addClass("selected");

	});
	$('body.home .article-nav li#articles-latest-news').trigger('click');



	// disable initial click on mobile
	if(isTouchDevice()){
		$(".big-three li > a").click(function(e){
			if(!$(this).hasClass("touched")){
				e.preventDefault();
				$(".big-three li > a").removeClass("touched");
				$(this).addClass("touched");
			}
		});
	}
	 // embed real estate report pdf

var success = new PDFObject({ url: "/wp-content/themes/ddp/images/real_estate_development.pdf"}).embed('development-element');



});






