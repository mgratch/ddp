		<footer>

      	<div class="row footer">
      		<div class="col-md-4"><h4>Get in Touch</h4>
			<br>

      		<?php print wpautop(get_post_meta(get_option('page_on_front'), 'wpcf-copyright-block', true)); ?>
      		<a href="http://instagram.com/downtowndetroitpartnership#"><img class="social" src="<?php echo get_template_directory_uri(); ?>/images/instagram-header2.png" /></a><a href="https://twitter.com/DDPDetroit"><img class="social" src="<?php echo get_template_directory_uri(); ?>/images/twitter-header2.png" /></a><a href="https://www.facebook.com/DowntownDetroitPartnership"><img class="social" src="<?php echo get_template_directory_uri(); ?>/images/facebook-header2.png" /></a>
      		</div>
      		<div class="col-md-4">
      		<h4>Subscribe to our newsletter</h4>
      		<!-- Begin MailChimp Signup Form -->
				<div id="mc_embed_signup" class="clearfix">
				<br>
				Want to stay informed about what's happening in downtown Detroit? Enter your email to join today.
				<form action="//downtowndetroit.us6.list-manage.com/subscribe/post?u=44a8ea582b778dc0d652d86ed&amp;id=fd850cfc79" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<div class="mc-field-group">
					<label for="mce-EMAIL"></label><br>
					<input type="email" placeholder="email address" name="EMAIL" class="required email" id="mce-EMAIL">
				</div>
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
				    <div style="position: absolute; left: -5000px;"><input type="text" name="b_44a8ea582b778dc0d652d86ed_669ce34c9c" value=""></div>
					<input type="submit" value="" name="subscribe" id="mc-embedded-subscribe" class="button">
				</form>
				</div>

			<!--End mc_embed_signup-->

			</div>

      		<div class="col-md-4"><h4>About The Downtown Detroit Partnership</h4>
			<br>
			Downtown Detroit Partnership is a partnership of corporate, civic and philanthropic leaders that supports advocates and develops programs and initiatives designed to create a clean, safe, and inviting Downtown Detroit.
      		</div>


      	</div>


      </footer>

    </div><!-- end #wrapper -->

    <div id="about-menu">

    	<div class="search">
    		<form role="search" method="get" action="<?php bloginfo('url'); ?>/">
    			<input id="search s" name="s" type="text" class="search-input" placeholder="Search" />
    			<input type="submit" class="submit" value="" />
    		</form>
    	</div>
    						<div class="responsive-sidebar-nav">
    						<div class="responsive-item explore">

				  				<span class="img-container"><img src="<?php echo get_template_directory_uri(); ?>/images/explore-icon.png" /></span>

	    						<h5>Explore Downtown</h5>
	            				<?php
				  				$defaults = array(
									'theme_location'  => '',
									'menu'            => 'Explore',
									'container'       => '',
									'container_class' => '',
									'container_id'    => '',
									'menu_class'      => 'sub-menu',
									'menu_id'         => '',
									'echo'            => true,
									'fallback_cb'     => 'wp_page_menu',
									'before'          => '',
									'after'           => '',
									'link_before'     => '',
									'link_after'      => '',
									'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									'depth'           => 0,
									'walker'          => ''
								);

								wp_nav_menu( $defaults );
								?>
    						</div>
    						<div class="responsive-item do-business">

				  				<span class="img-container"><img src="<?php echo get_template_directory_uri(); ?>/images/business-icon.png" /></span>

	    						<h5>Do Business</h5>
	            				<?php
				  				$defaults = array(
									'theme_location'  => '',
									'menu'            => 'Do Business',
									'container'       => '',
									'container_class' => '',
									'container_id'    => '',
									'menu_class'      => 'sub-menu',
									'menu_id'         => '',
									'echo'            => true,
									'fallback_cb'     => 'wp_page_menu',
									'before'          => '',
									'after'           => '',
									'link_before'     => '',
									'link_after'      => '',
									'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									'depth'           => 0,
									'walker'          => ''
								);

								wp_nav_menu( $defaults ); ?>

    						</div>
    						<div class="responsive-item live-here">

				  				<span class="img-container"><img src="<?php echo get_template_directory_uri(); ?>/images/live-icon.png" /></span>

    							<h5>Live Here</h5>
								<?php
				  				$defaults = array(
									'theme_location'  => '',
									'menu'            => 'Live Here',
									'container'       => '',
									'container_class' => '',
									'container_id'    => '',
									'menu_class'      => 'sub-menu',
									'menu_id'         => '',
									'echo'            => true,
									'fallback_cb'     => 'wp_page_menu',
									'before'          => '',
									'after'           => '',
									'link_before'     => '',
									'link_after'      => '',
									'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									'depth'           => 0,
									'walker'          => ''
								);

								wp_nav_menu( $defaults ); ?>

    						</div>
                <div class="responsive-item biz-zone">

                  <span class="img-container"><img src="<?php echo get_template_directory_uri(); ?>/images/biz-icon.png" /></span>

                  <h5>Business Improvement Zone</h5>
                <?php
                  $defaults = array(
                  'theme_location'  => '',
                  'menu'            => 'BIZ Zone',
                  'container'       => '',
                  'container_class' => '',
                  'container_id'    => '',
                  'menu_class'      => 'sub-menu',
                  'menu_id'         => '',
                  'echo'            => true,
                  'fallback_cb'     => 'wp_page_menu',
                  'before'          => '',
                  'after'           => '',
                  'link_before'     => '',
                  'link_after'      => '',
                  'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                  'depth'           => 0,
                  'walker'          => ''
                );

                wp_nav_menu( $defaults ); ?>

                </div>
    						</div>
    						<?php
			  				$defaults = array(
								'theme_location'  => '',
								'menu'            => 'OffCanvas',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'main-menu',
								'menu_id'         => '',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth'           => 0,
								'walker'          => ''
							);

							wp_nav_menu( $defaults );
							?>

							<div class="social">
				  				<a href="http://instagram.com/downtowndetroitpartnership#"><img src="<?php echo get_template_directory_uri(); ?>/images/instagram-header2.png" /></a>
				  				<a href="https://www.facebook.com/DowntownDetroitPartnership"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter-header2.png" /></a>
				  				<a href="https://twitter.com/DDPDetroit"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook-header2.png" /></a>
				  			</div>
    	<!--
    	<ul>
    		<li><a href="#"><strong>About</strong></a></li>
    		<li><a href="#">Our Mission</a></li>
    		<li><a href="#">DDP Board</a></li>
    		<li><a href="#">Our Staff</a></li>
    		<li><a href="#">Members</a></li>
    	</ul>
    	<ul>
    		<li><a href="#"><strong>Our Events</strong></a></li>
    		<li><a href="#">Annual Meeting</a></li>
    		<li><a href="#">Detroit Aglow</a></li>
    		<li><a href="#">Stakeholder Meeting</a></li>
    		<li><a href="#">Archive</a></li>
    	</ul>
    	<ul>
    		<li><a href="#"><strong>News</strong></a></li>
    		<li><a href="#">Recent News</a></li>
    		<li><a href="#">Press Releases</a></li>
    		<li><a href="#">Annual Reports</a></li>
    	</ul>
    	<ul>
    		<li><a href="#"><strong>Contact</strong></a></li>
    		<li><a href="#">Get in Touch</a></li>
    	</ul>
    	-->

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->


    <script src="<?php echo get_template_directory_uri(); ?>/javascript/idangerous.swiper.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/javascript/bootstrap.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/javascript/jquery.mobile.custom.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/javascript/ddp.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/javascript/jquery.tinysort.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/javascript/pdfobject.js"></script>


		<?php wp_footer(); ?>

	<script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-50703938-1');ga('send','pageview');
        </script>

	</body>
</html>
