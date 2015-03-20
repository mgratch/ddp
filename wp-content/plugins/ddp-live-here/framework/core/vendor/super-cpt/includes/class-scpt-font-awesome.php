<?php

namespace ddp\live;

/**
 * A custom integration of the Font Awesome icon library for SuperCPT
 */

if ( !class_exists( 'SCPT_Font_Awesome' ) ) :

class SCPT_Font_Awesome extends Super_CPT {

	private static $instance;

	public $styles = array();

	public $font_dir = '';

	private function __construct() {
		/* Don't do anything, needs to be initialized via instance() method */
	}

	public function __clone() { wp_die( "Please don't __clone SCPT_Font_Awesome" ); }

	public function __wakeup() { wp_die( "Please don't __wakeup SCPT_Font_Awesome" ); }

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new SCPT_Font_Awesome;
			self::$instance->setup();
		}
		return self::$instance;
	}

	public function setup() {
		$this->font_dir = $this->config['plugin_url'] . 'fonts/';
		$this->styles['icons'] = array();

		add_action( 'admin_print_styles', array( $this, 'add_styles' ) );
		add_action( 'scpt_plugin_icon_demos', array( $this, 'icon_demo' ) );
		add_filter( 'scpt_plugin_icon_font_awesome', array( $this, 'set_font_awesome_icon' ), 10, 3 );
	}


	/**
	 * Add styles to the site <head> if applicable
	 *
	 * @return void
	 */
	public function add_styles() {
		if ( ! empty( $this->styles ) ) :
			?>
			<style type="text/css">
				<?php do_action( 'scpt_plugin_icon_css' ) ?>
			</style>
			<?php
		endif;
	}


	/**
	 * Set an icon for a post type from the Font Awesome library
	 *
	 * @param string $none 'none', shouldn't be changed here.
	 * @param array $icon the array argument passed to Super_Custom_Post_Type::set_icon()
	 * @param string $post_type
	 * @return string
	 */
	public function set_font_awesome_icon( $none, $icon, $post_type ) {
		if ( isset( $icon['name'] ) ) {
			$this->register_font_awesome();
			$this->styles['icons'][ $post_type ] = $icon['name'];
		}
		return $none;
	}


	/**
	 * We're going to be using Font Awesome for icons, so prepare the CSS that will be injected into the page
	 *
	 * @param string $post_type
	 * @return void
	 */
	public function register_font_awesome() {
		if ( ! isset( $this->styles['base'] ) ) {
			$this->styles['base'] = "
			@font-face { font-family: 'FontAwesome'; src: url('{$this->font_dir}fontawesome-webfont.eot?v=3.1.0'); src: url('{$this->font_dir}fontawesome-webfont.eot?#iefix&v=3.1.0') format('embedded-opentype'), url('{$this->font_dir}fontawesome-webfont.woff?v=3.1.0') format('woff'), url('{$this->font_dir}fontawesome-webfont.ttf?v=3.1.0') format('truetype'), url('{$this->font_dir}fontawesome-webfont.svg#fontawesomeregular?v=3.1.0') format('svg'); font-weight: normal; font-style: normal; }
			%s { font-family: FontAwesome !important; -webkit-font-smoothing: antialiased; background: none; *margin-right: .3em; " . $this->pre_mp6_styles() . " }
			%s { font-family: FontAwesome !important; }
			%s { " . $this->pre_mp6_styles( 'hover' ) . " }
			%s { " . $this->pre_mp6_styles( 'open' ) . " }";
			add_action( 'scpt_plugin_icon_css', array( $this, 'output_font_awesome' ) );
		}
	}


	public function pre_mp6_styles( $state = 'normal' ) {
		if ( function_exists( 'mp6_force_admin_color' ) )
			return;
		if ( 'normal' == $state )
			return 'font-size:18px;text-align:center;line-height:28px;color:#888;';
		elseif ( 'hover' == $state )
			return 'color:#d54e21;';
		elseif ( 'open' == $state )
			return 'color:#fff;';
	}


	/**
	 * Output relevant styles for Font Awesome
	 * @return type
	 */
	public function output_font_awesome() {
		$cache_key = 'scpt-fa-' . md5( serialize( $this->styles ) );
		if ( false === ( $content = get_transient( $cache_key ) ) ) {
			$content = '';
			$normal = $before = array();
			foreach ( $this->styles['icons'] as $post_type => $icon ) {
				$temp = "#adminmenu #menu-posts-{$post_type} div.wp-menu-image";
				$normal[] = $temp;
				$before[] = $temp . ':before';
				$hover[] = "#adminmenu #menu-posts-{$post_type}:hover div.wp-menu-image";
				$open[] = "#adminmenu #menu-posts-{$post_type}.wp-menu-open div.wp-menu-image";
				$hex = $this->get_font_awesome_icon( $icon );
				$content .= "\n#adminmenu #menu-posts-{$post_type} div.wp-menu-image:before { content: '{$hex}' !important; }";
			}
			$content = sprintf( $this->styles['base'], implode( ',', $normal ), implode( ',', $before ), implode( ',', $hover ), implode( ',', $open ) ) . $content;
			set_transient( $cache_key, $content, HOUR_IN_SECONDS );
		}
		echo $content;
	}


function SCPT_Font_Awesome() {
	return SCPT_Font_Awesome::instance();
}
SCPT_Font_Awesome();

endif;