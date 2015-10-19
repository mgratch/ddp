		<?php do_action('legacy_asset_end'); ?>
		  <div id="footer-push"></div>
    </div>
		<footer class="footer footer--main">
      <div class="footer__vert-centered-content">
        <div class="footer--main__content">
          <div class="footer--main__content__item">
            <h4 class="headline headline--light headline--shout headline--color-2 footer--main__content__title">Get In Touch</h4>
            <div>
            <?php
              $companyInfo = ioAdminHelpers::getCompany();
              $strHtml = '';

              if (!empty($companyInfo['company-name'])) {
                $strHtml .= '<div>'.$companyInfo['company-name'].'</div>';
              }
              if (!empty($companyInfo['company-street-address']) && !empty($companyInfo['company-city']) && !empty($companyInfo['company-state']) && !empty($companyInfo['company-zipcode'])) {
                $strHtml .= '<div>';
                  $strHtml .= '<span>'.$companyInfo['company-street-address'].'</span>';
                  if (!empty($companyInfo['company-street-address-2'])) {
                    $strHtml .= '<span>, '.$companyInfo['company-street-address-2'].'</span>';
                  }
                $strHtml .= '</div>';
                $strHtml .= '<div>'.$companyInfo['company-city'].', '.$companyInfo['company-state'].' '.$companyInfo['company-zipcode'].'</div>';
              }
              if (!empty($companyInfo['company-phone-number'])) {
                $strippedPhone = preg_replace('/\D+/', '', $companyInfo['company-phone-number']);

                $strHtml .= '<div><a class="footer__link footer--main__content__link" href="tel:'.$strippedPhone.'">'.$companyInfo['company-phone-number'].'</a></div>';
              }
              if (!empty($companyInfo['company-phone-number-2'])) {
                $strHtml .= '<div>'.$companyInfo['company-phone-number-2'].'</div>';
              }
              if (!empty($companyInfo['company-email-address'])) {
                $strHtml .= '<div><a class="footer__link footer--main__content__link" href="mailto:'.$companyInfo['company-email-address'].'">'.$companyInfo['company-email-address'].'</a></div>';
              }

              echo $strHtml;
            ?>
            </div>
          </div>
          <div class="footer--main__content__item">
            <h4 class="headline headline--light headline--shout headline--color-2 footer--main__content__title">Subscribe To Our Newsletter</h4>
            <p>Want to stay informed about what's happening in downtown Detroit? Enter your email to join today.</p>
            <!-- Begin MailChimp Signup Form -->
            <div id="mc_embed_signup">
              <form class="form form--single-input" action="//downtowndetroit.us6.list-manage.com/subscribe/post?u=44a8ea582b778dc0d652d86ed&amp;id=fd850cfc79" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                <div class="mc-field-group form--single-input__item form--single-input__input">
                  <label class="visually-hidden" for="mce-EMAIL"></label>
                  <input type="email" placeholder="email address" name="EMAIL" class="required email form__input" id="mce-EMAIL">
                </div>
                <div id="mce-responses" class="clear">
                  <div class="response" id="mce-error-response" style="display:none"></div>
                  <div class="response" id="mce-success-response" style="display:none"></div>
                </div>
                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <input class="visually-hidden" type="text" name="b_44a8ea582b778dc0d652d86ed_669ce34c9c" value="">
                <input type="submit" value="" name="subscribe" id="mc-embedded-subscribe" class="button button--color-4 button--plus form--single-input__item">
              </form>
            </div>
            <!--End mc_embed_signup-->
          </div>
          <div class="footer--main__content__item">
            <h4 class="headline headline--light headline--shout headline--color-2 footer--main__content__title">Support the Downtown Detroit Partnership</h4>
            <p>Help us out, this is dummy text but it’s the intro for the Support section and will fill this space.</p>
            <a class="button button--cta button--color-2 button--shout" href="#">Call To Action</a>
          </div>
        </div>
  			<p class="footer__copyright">&copy; Copyright <?php echo date('Y'); ?> <a class="footer__link" href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> </p>
      </div>
		</footer>

		<!-- Facebook SDK -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1662450680668324";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<?php wp_footer();
      // var_dump($companyInfo);
    ?>
	</body>
</html>
