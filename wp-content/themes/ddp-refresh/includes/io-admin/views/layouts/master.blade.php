@yield( 'styles' )

<div class="wrap">
  <div id="icon-options-general" class="icon32"></div>
  <h2><i class="iodd-iodd-icon"></i> {{ $page_title or 'Page Title' }}</h2>
  {{ ioAdmin\ioAdminPages\ioAdminPages::userMessages() }}

  <div id="poststuff">
    <div id="post-body" class="metabox-holder columns-2">

    <!-- sidebar -->
      <div id="postbox-container-1" class="postbox-container">
        @section('sidebar')
          <div class="postbox">
              <h3><span>Save Settings</span></h3>
              <div class="inside">
                <button type="button" style="width:100%;" class="btn btn-primary btn-block" data-primary-submit>Save Settings</button>
              </div> <!-- .inside -->
          </div> <!-- .postbox -->
        @show
      </div> <!-- #postbox-container-1 .postbox-container -->

      <!-- main content -->
      <div id="post-body-content">
        @yield( 'content' )
      </div> <!-- post-body-content -->

    </div> <!-- #post-body .metabox-holder .columns-2 -->
    <br class="clear">
  </div> <!-- #poststuff -->
</div> <!-- .wrap -->

@yield( 'js' )