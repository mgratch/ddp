<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html  <?php language_attributes(); ?>> <!--<![endif]-->

	<head>
		<meta http-equiv="Content-Type; X-UA-Compatible" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>; IE=edge">
		<title><?php wp_title(); ?> | <?php bloginfo('name'); ?></title>

		<link rel="shortcut icon" href="/favicon.ico" />

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Removes auto phone number detection on iOS -->
		<meta name="format-detection" content="telephone=no">

		<!-- GOOGLE FONTS USED: Add stylesheet link from google below and list font names/weights here -->

		<?php wp_enqueue_style( 'theme-meta', get_stylesheet_uri() ); ?>
		<!-- theme stylesheet for modern browsers and alternate sheet for ie8 media-query and rem fallbacks -->
		<!--[if (gt IE 8) | (IEMobile)]><!-->
		  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css" media="all">
		<!--<![endif]-->

		<!--[if (lt IE 9) & (!IEMobile)]>
		  <script>
				/**
				* @preserve HTML5 Shiv 3.7.2 | @afarkas @jdalton @jon_neal @rem | MIT/GPL2 Licensed
				*/
				!function(a,b){function c(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function d(){var a=t.elements;return"string"==typeof a?a.split(" "):a}function e(a,b){var c=t.elements;"string"!=typeof c&&(c=c.join(" ")),"string"!=typeof a&&(a=a.join(" ")),t.elements=c+" "+a,j(b)}function f(a){var b=s[a[q]];return b||(b={},r++,a[q]=r,s[r]=b),b}function g(a,c,d){if(c||(c=b),l)return c.createElement(a);d||(d=f(c));var e;return e=d.cache[a]?d.cache[a].cloneNode():p.test(a)?(d.cache[a]=d.createElem(a)).cloneNode():d.createElem(a),!e.canHaveChildren||o.test(a)||e.tagUrn?e:d.frag.appendChild(e)}function h(a,c){if(a||(a=b),l)return a.createDocumentFragment();c=c||f(a);for(var e=c.frag.cloneNode(),g=0,h=d(),i=h.length;i>g;g++)e.createElement(h[g]);return e}function i(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return t.shivMethods?g(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+d().join().replace(/[\w\-:]+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(t,b.frag)}function j(a){a||(a=b);var d=f(a);return!t.shivCSS||k||d.hasCSS||(d.hasCSS=!!c(a,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),l||i(a,d),a}var k,l,m="3.7.2",n=a.html5||{},o=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,p=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,q="_html5shiv",r=0,s={};!function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",k="hidden"in a,l=1==a.childNodes.length||function(){b.createElement("a");var a=b.createDocumentFragment();return"undefined"==typeof a.cloneNode||"undefined"==typeof a.createDocumentFragment||"undefined"==typeof a.createElement}()}catch(c){k=!0,l=!0}}();var t={elements:n.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output picture progress section summary template time video",version:m,shivCSS:n.shivCSS!==!1,supportsUnknownElements:l,shivMethods:n.shivMethods!==!1,type:"default",shivDocument:j,createElement:g,createDocumentFragment:h,addElements:e};a.html5=t,j(b)}(this,document);
		  </script>
		  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style-ie.css" media="all">
		<![endif]-->

		<?php
			wp_enqueue_script('jquery');
			wp_enqueue_script('ioddcommon');
			wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<?php if (is_front_page()): ?>
			<!-- Facebook SDK -->
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1662450680668324";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		<?php endif ?>

		<div class="content-wrap">
			<header class="header header--main js-main-header">
				<div class="header--main__item site-logo">
            <a class="site-logo__link" title="<?php bloginfo('name'); ?> - Home" href="<?php echo home_url('/'); ?>">
              <img class="site-logo__image" src="<?php echo get_template_directory_uri();?>/images/site-logo.svg" onerror="this.src='<?php echo get_template_directory_uri();?>/images/site-logo.png';this.onerror=null;" alt="<?php bloginfo('name'); ?>">
							<?php echo renderSVG(get_template_directory().'/images/site-icon.svg'); ?>
            </a>
				</div>
				<div class="mobile-button">menu</div>
				<nav class="header--main__item nav nav--main">
					<div class="table table--2-items-flex-first">
						<div class="table__item">
						<?php wp_nav_menu(array('theme_location'=>'main', 'container'=>false, 'menu_class'=>'menu menu--main js-header-compress', 'container_class'=>false, 'menu_id'=>false, 'walker' => new IODDPWalker)); ?>
						</div>
						<div class="table__item">
						<?php
							$social_urls = ioAdminHelpers::getSocial();

							if (!empty($social_urls)) {
								$strHtml = '';

								$strHtml .= '<div class="social-connect">';
									$strHtml .= '<span class="social-connect__title">Follow Us</span>';
									$strHtml .= '<ul class="list social-connect__list">';
										foreach ($social_urls as $key => $service) {
											if (!empty($service)) {
												$strHtml .= '<li class="list__item">';
													$strHtml .= '<a class="social-connect__link" href="'.$service.'" target="_blank">';
														$strHtml .= renderSVG(get_template_directory().'/images/logo-'.$key.'.svg');
													$strHtml .= '</a>';
												$strHtml .= '</li>'."\r\n";
											}
										}

									$strHtml .= '</ul>';
								$strHtml .= '</div>';

								echo $strHtml;
							}
						?>
						</div>
					</div>
				</nav>
			</header>
			<?php
				do_action('legacy_asset_start');
			?>
