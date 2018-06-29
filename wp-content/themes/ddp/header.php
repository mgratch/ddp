<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>

		<!-- "H5": The HTML-5 WordPress Template Theme -->
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
		<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>

    	<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" href="<?php echo site_url(); ?>/favicon.ico" />
		<link href="<?php echo get_template_directory_uri(); ?>/css/idangerous.swiper.css" rel="stylesheet" />
    	<link href="<?php echo get_template_directory_uri(); ?>/bootstrap/css/bootstrap.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style_print.css" media="print">
		<link rel="alternate" type="text/xml" title="<?php bloginfo('name'); ?> RSS 0.92 Feed" href="<?php bloginfo('rss_url'); ?>">
		<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>">
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS 2.0 Feed" href="<?php bloginfo('rss2_url'); ?>">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php wp_enqueue_script('jquery'); ?>
		<?php wp_head(); ?>
		 <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		    <!--[if lt IE 9]>
		      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		    <![endif]-->

	</head>
	<body <?php body_class(); ?>>

		<header class="">

	  		<nav class="main-nav">
	  			<a href="<?php echo home_url(); ?>"><div class="brand"></div></a>
	  			<ul class="big-three">
	  				<li id="m-0" class="explore">

	  					<div>
	  						<a href="<?php bloginfo('url'); ?>/explore-downtown/">
			  				<span class="img-container"><img src="<?php echo get_template_directory_uri(); ?>/images/explore-icon.png" /></span>
			  				Explore Downtown
			  				</a>
			  			</div>

			  			<div class="dropdown-menu">
			  				<?php
			  				$defaults = array(
								'theme_location'  => '',
								'menu'            => 'Explore',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'menu-explore',
								'menu_id'         => '',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth'           => 0,
								'walker'          => new ddp_nav_walker
							);

							wp_nav_menu( $defaults );
							?>

			  				<div class="description"><a href="<?php bloginfo('url'); ?>/explore-downtown/"><?php print get_post_meta(get_option('page_on_front'), 'wpcf-explore-description', true); ?></a></div>

			  			</div>
	  				</li>
	  				<li id="m-1" class="business">

						<div >
							<a href="<?php bloginfo('url'); ?>/do-business/">
			  				<span class="img-container"><img src="<?php echo get_template_directory_uri(); ?>/images/business-icon.png" /></span>
			  				Do Business
			  				</a>
			  			</div>

			  			<div class="dropdown-menu">
			  				<?php
			  				$defaults = array(
								'theme_location'  => '',
								'menu'            => 'Do Business',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'menu-explore',
								'menu_id'         => '',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth'           => 0,
								'walker'          => new ddp_nav_walker()
							);

							wp_nav_menu( $defaults );
							?>

			  				<div class="description"><a href="<?php bloginfo('url'); ?>/do-business/"><?php print get_post_meta(get_option('page_on_front'), 'wpcf-do-business-description', true); ?></a></div>

			  			</div>
	  				</li>

	   				<li id="m-2" class="live">

	  					<div>
	  						<a href="<?php bloginfo('url'); ?>/live-here/">
			  				<span class="img-container"><img src="<?php echo get_template_directory_uri(); ?>/images/live-icon.png" /></span>
			  				Live Here
			  				</a>
			  			</div>

			  			<div class="dropdown-menu">
			  				<?php
			  				$defaults = array(
								'theme_location'  => '',
								'menu'            => 'Live Here',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'menu-explore',
								'menu_id'         => '',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth'           => 0,
								'walker'          => new ddp_nav_walker
							);

							wp_nav_menu( $defaults );
							?>

			  				<div class="description"><a href="<?php bloginfo('url'); ?>/live-here/"><?php print get_post_meta(get_option('page_on_front'), 'wpcf-live-here-description', true); ?></a></div>

			  			</div>
	  				</li>

	  				<li id="m-3" class="biz-improvement">

	  					<div>
	  						<a href="<?php bloginfo('url'); ?>/business-improvement-zone/">
			  				<span class="img-container"><img src="<?php echo get_template_directory_uri(); ?>/images/biz-icon.png" /></span>
			  				<span class="short-label">BIZ</span>
			  				<span class="long-label">Business Improvement Zone</span>
			  				</a>
			  			</div>

			  			<div class="dropdown-menu">
			  				<?php
			  				$defaults = array(
								'theme_location'  => '',
								'menu'            => 'BIZ Zone',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'menu-explore',
								'menu_id'         => '',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth'           => 0,
								'walker'          => new ddp_nav_walker
							);

							wp_nav_menu( $defaults );
							?>

			  				<div class="description"><a href="<?php bloginfo('url'); ?>/business-improvement-zone/"><?php print get_post_meta(get_option('page_on_front'), 'wpcf-biz-zone-description', true); ?></a></div>

			  			</div>
	  				</li>
	  			</ul>



	  			<a class="about" href="#">
	  			Menu
	  			<span><img src="<?php echo get_template_directory_uri(); ?>/images/arrow-sprite.png" /></span>
	  			</a>

	  			<div class="social">
	  				<a href="http://instagram.com/downtowndetroitpartnership#" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/instagram-header2.png" /></a>
	  				<a href="https://twitter.com/DDPDetroit" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter-header2.png" /></a>
	  				<a href="https://www.facebook.com/DowntownDetroitPartnership" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook-header2.png" /></a>
	  			</div>

	  		</nav>
	  	</header>

	  	<div id="wrapper">
