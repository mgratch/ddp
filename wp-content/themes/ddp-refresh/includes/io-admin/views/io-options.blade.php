@extends( $layout )

@section('content')
  {{ ioHTML::formOpen('', 'post', ['id' => 'io-options']) }}
  <div class="postbox">
    <h3><span>Company Info</span></h3>
    <div class="inside">
      <div class="form-group">
        <label>Company Name</label>
        {{ ioHTML::input( 'company-info[company-name]', !empty($options['company-info']["company-name"]) ? $options['company-info']["company-name"] : null, ['placeholder' => 'Company Name'] ) }}
      </div>

      <div class="form-group">
        <label>Company Phone Number</label>
        {{ ioHTML::input( 'company-info[company-phone-number]', !empty($options['company-info']["company-phone-number"]) ? $options['company-info']["company-phone-number"] : null, ['placeholder' => 'Company Phone'] ) }}
      </div>

      <div class="form-group">
        <label>Company Alt / Secondary Phone</label>
        {{ ioHTML::input( 'company-info[company-phone-number-2]', !empty($options['company-info']["company-phone-number-2"]) ? $options['company-info']["company-phone-number-2"] : null, ['placeholder' => 'Alt / Secondary Phone'] ) }}
      </div>

      <div class="form-group">
        <label>Company Contact Email Address</label>
        {{ ioHTML::input(
            'company-info[company-email-address]',
            !empty($options['company-info']["company-email-address"]) ? $options['company-info']["company-email-address"] : null,
            ['type' => 'email', 'placeholder' => 'example@example.com'] ) }}
      </div>

      <div class="form-group">
        <label>Company Street Address</label>
        {{ ioHTML::input(
          'company-info[company-street-address]',
          !empty($options['company-info']['company-street-address']) ? $options['company-info']['company-street-address'] : null,
          ['placeholder' => 'Company Street Address'] ) }}
      </div>


      <div class="form-group">
        <label>Company Street Address 2</label>
        {{ ioHTML::input(
          'company-info[company-street-address-2]',
          !empty($options['company-info']['company-street-address-2']) ? $options['company-info']['company-street-address-2'] : null,
          ['placeholder' => 'Company Street Address 2'] ) }}
      </div>

      <div class="fluid-container">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Company City</label>
              {{ ioHTML::input(
                  'company-info[company-city]',
                  !empty($options['company-info']['company-city']) ? $options['company-info']['company-city'] : null,
                  ['placeholder' => 'Company City'] ) }}
            </div> <!-- form-group -->
          </div> <!-- col -->
          <div class="col-md-4">
            <div class="form-group">
              <label>Company State</label>
              {{ ioHTML::select(
                'company-info[company-state]',
                $states,
                !empty($options['company-info']['company-state']) ? $options['company-info']['company-state'] : null,
                ['form' => 'io-options'] ) }}
            </div> <!-- form-group -->
          </div> <!-- col -->
          <div class="col-md-4">
            <div class="form-group">
              <label>Company Zipcode</label>
              {{ ioHTML::input(
                'company-info[company-zipcode]',
                !empty($options['company-info']["company-zipcode"]) ? $options['company-info']["company-zipcode"] : null,
                ['placeholder' => 'Company Zipcode']
                )}}
            </div> <!-- form-group -->
          </div> <!-- col -->
        </div> <!-- row -->
      </div> <!-- fluid-container -->

    </div> <!-- .inside -->
  </div> <!-- .postbox -->

  <div class="postbox">
    <h3><span>Footer Content/Legal Disclaimer</span></h3>
    <div class="inside">
      <div class="form-group">
        <?php
          $content = !empty($options['footer-content']['footer-disclaimer']) ? stripslashes($options['footer-content']['footer-disclaimer']) : null;
          wp_editor( $content, 'footer-disclaimer', ['textarea_name' => 'footer-content[footer-disclaimer]'] );
        ?>
      </div>
    </div> <!-- .inside -->
  </div> <!-- .postbox -->

  <div class="postbox">
    <h3><span>Social URL</span></h3>
    <div class="inside">

      @foreach($social_fields as $s_id => $s_title)
        <div class="form-group">
          <label>{{ $s_title }} URL</label>
          {{ ioHTML::input(
            'social-links['.$s_id.']',
            !empty($options['social-links'][$s_id]) ? $options['social-links'][$s_id] : null,
            ['placeholder' => 'http://']
            ) }}
        </div>
    @endforeach

    </div> <!-- .inside -->
  </div> <!-- .postbox -->
  {{ ioHTML::formClose() }}
@stop

@section('js')
  <script type="text/javascript">
    jQuery(function($) {
      $('[data-primary-submit]').click(function() { $('#io-options').submit() });
    });
  </script>
@stop