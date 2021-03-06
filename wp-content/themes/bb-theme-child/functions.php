<?php

// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );

// Classes
require_once 'classes/class-fl-child-theme.php';

// Actions
add_action( 'wp_enqueue_scripts', 'FLChildTheme::enqueue_scripts', 1000 );

function get_social_network_menu_items() {
	$items      = wp_get_nav_menu_items( 'social-networks' );
	$html_items = '<li class="social-networks"><ul class="social-sub-menu">';

	foreach ( $items as $item ) {
		$html_items .= "<li id='menu-item-" . $item->ID . "' class='menu-item menu-item-type-custom menu-item-object-custom" . implode( ' ', $item->classes ) . "'><a href='" . $item->url . "' rel='" . $item->xfn . "' target='" . $item->target . "'>" . $item->title . "</a></li>";
	}
	$html_items .= '</ul></li>';

	return $html_items;
}

function insert_social_network_menu_items( $items, $args ) {
	return $items . get_social_network_menu_items();
}

//add_filter('wp_nav_menu_main_items','insert_social_network_menu_items', 10, 2);

function year_shortcode() {
	$year = date( 'Y' );

	return $year;
}

add_shortcode( 'year', 'year_shortcode' );

add_filter( 'gform_submit_button_4', 'input_to_button', 10, 2 );
function input_to_button( $button, $form ) {
	$dom = new DOMDocument();
	$dom->loadHTML( $button );
	$input = $dom->getElementsByTagName( 'input' )->item( 0 );
	$input->setAttribute( 'value', '' );

	return $dom->saveHtml( $input );
}

class IODDPSubWalker extends Walker_Nav_Menu {

	function walk( $elements, $max_depth ) {
		global $post, $topParentTitle;


		$parent_page_id = get_top_parent_id( $post );

		//crappy solution for Events side menu
		$strEventParentTitle     = 'Events';
		$strEventParentMenuTitle = 'Upcoming Events';


		$menu_elements = array();
		foreach ( $elements as $element ) {

			if ( $element->menu_item_parent == 0 ) {

				$children_items = array();
				foreach ( $elements as $s_element ) {
					if ( $element->db_id == $s_element->menu_item_parent ) {
						$children_items[] = $s_element;
					}
				}

				if ( count( $children_items ) > 0 ) {
					$childItems[ $element->db_id ] = $children_items;
				}
				$menu_elements[] = $element;
			} else {
				$children_items = array();
				foreach ( $elements as $s_element ) {
					if ( $element->db_id == $s_element->menu_item_parent ) {
						$children_items[] = $s_element;
					}
				}

				if ( count( $children_items ) > 0 ) {
					$childItems[ $element->menu_item_parent ]['sub'][ $element->db_id ] = $children_items;
				}
			}
		}

		$strHtml = '';

		foreach ( $menu_elements as $item ) {
			//only show selected parent tree

			if ( $item->object_id == $parent_page_id || ( $topParentTitle == $strEventParentTitle && $item->title == $strEventParentMenuTitle ) ) {
				$classes = join( ' ', io_menu_standards( $item->classes, $item ) );

				if ( isset( $childItems[ $item->db_id ] ) ) {

					$strSubHtml = '';
					foreach ( $childItems[ $item->db_id ] as $key => $subitem ) {

						if ( $key !== 'sub' ) {
							$classes = join( ' ', io_menu_standards( $subitem->classes, $subitem ) );

							$strHtml .= '<li id="menu-' . $subitem->db_id . '" class="' . $classes . '"><a href="' . $subitem->url . '" class="menu__link">' . $subitem->title . '</a>';

							if ( ! empty( $childItems[ $item->db_id ]['sub'][ $subitem->db_id ] ) ) {

								$strHtml .= '<ul class="menu menu--sub-sub-menu">';
								foreach ( $childItems[ $item->db_id ]['sub'][ $subitem->db_id ] as $key2 => $subitem2 ) {
									$classes = join( ' ', io_menu_standards( $subitem2->classes, $subitem2 ) );

									$strHtml .= '<li id="menu-' . $subitem2->db_id . '" class="' . $classes . '"><a href="' . $subitem2->url . '" class="menu__link">' . $subitem2->title . '</a></li>';
								}
								$strHtml .= '</ul>';
							}
						}
						$strHtml .= '</li>';
					}
				}
			}
		}

		return $strHtml;
	}
}

class IODDPWalker extends Walker_Nav_Menu {

	private $last_item = false;

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$args   = (object) $args;

		$class_names = '';
		$value       = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$submenu = $args->has_children ? ' fl-has-submenu' : '';

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = ' class="' . esc_attr( $class_names ) . $submenu . '"';


		if ( isset( $item->group_start ) && true === $item->group_start ) {
			$output .= "<ul class='menu--sub-menu table__item'>";
		} else {
			$output .= '';
		}

		$output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

		$atts = array();

		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = ! empty( $atts['classes'] ) ? ' class="' . esc_attr( join( '', array_filter( $atts['classes'] ) ) ) . '"' : '';
		$attributes .= ! empty( $item->attr_title ) ? ' title="' . esc_attr( $atts['title'] ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $atts['target'] ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $atts['rel'] ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $atts['href'] ) . '"' : '';

		$item_output = $args->has_children ? '<div class="fl-has-submenu-container">' : '';
		$item_output .= $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';

		if ( $args->has_children ) {
			$item_output .= '<span class="fl-menu-toggle"></span>';
		}

		$item_output .= $args->after;
		$item_output .= $args->has_children ? '</div>' : '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$output .= "</li>{$n}";

		if ( isset( $item->group_end ) && true === $item->group_end ) {
			$output .= "</ul>";
		} else {
			$output .= '';
		}

		if ( $args->last_item ) {
			$this->last_item = (int) $args->last_item;
		}

		if ( $this->last_item ) {
			if ( $item->ID === $this->last_item ) {

				$walker = class_exists( 'FL_Menu_Module_Walker' ) ? new FL_Menu_Module_Walker() : '';

				$defaults = array(
					'menu'       => 'social-networks',
					'container'  => false,
					'menu_class' => 'menu social-networks-menu menu__item',
					'walker'     => $walker,
					'echo'       => false
				);
				$output   .= wp_nav_menu( $defaults );
			}
		}

	}

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		parent::start_lvl( $output, $depth, $args );
		if ( 0 === $depth ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );
			$output .= "{$n}{$indent}<div class='table table--2-items'>{$n}";
		}
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 0 === $depth ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );
			$output .= "$indent</div>{$n}";
		}

		parent::end_lvl( $output, $depth, $args );

	}

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
			$args[0]->last_item    = isset( $element->last_item ) ? $element->last_item : false;
		}

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}


//add_action( 'fl_before_header', 'kick_off_walker', 11 );

function change_fl_nav_walker( $args ) {
	if ( 'main' === $args['menu'] && 'menu menu--side' !== $args['menu_class'] && false === strpos( $args['menu_class'], 'uabb-creative' ) && false === strpos( $args['menu_class'], 'mobile' ) ) {
		$args['walker'] = new IODDPWalker();
	} elseif ( 'main' === $args['menu'] && 'menu menu--side' !== $args['menu_class'] && false !== strpos( $args['menu_class'], 'mobile' ) ) {
		$args['menu_id'] = ! empty( $args['menu_id'] ) ? $args['menu_id'] . '-mobile' : 'menu-main-mobile';
	}

	return $args;
}

add_filter( 'wp_nav_menu_args', 'change_fl_nav_walker' );

// Map menu item class names
add_filter( 'nav_menu_css_class', 'io_menu_standards', 10, 2 );

function io_menu_standards( $classes, $item ) {
	$origClasses = $classes;

	$classes = [
		'menu__item'
	];

	if ( ! empty( $origClasses[0] ) ) {
		$classes = array_merge( $classes, $origClasses );
	}

	if ( $item->current ) {
		$classes[] = 'menu__item--current';
	}

	if ( $item->current_item_ancestor ) {
		$classes[] = 'menu__item--current-item-ancestor';
	}

	if ( $item->current_item_parent ) {
		$classes[] = 'menu__item--current-item-parent';
	}

	if ( in_array( 'menu-item-has-children', $origClasses ) ) {
		$classes[] = 'menu__item--has-children';
	}

	return $classes;
}

add_filter( 'nav_menu_link_attributes', 'io_menu_link_classes', 10, 3 );

function io_menu_link_classes( $atts, $item, $args ) {
	$atts['classes'][] = 'menu__link';

	return $atts;
}

add_filter( 'nav_menu_submenu_css_class', 'change_submenu_classes', 10, 3 );

function change_submenu_classes( $classes, $args, $depth ) {
	if ( 0 === $depth ) {
		$classes[] = 'menu__flyout';
	} else {

		$classes_keys = array_flip( $classes );
		if ( isset( $classes_keys['sub-menu'] ) ) {
			unset( $classes[ $classes_keys['sub-menu'] ] );
		}

		$classes[] = 'menu--sub-sub-menu';
	}

	return $classes;
}

function group_sub_menu_objects( $elements, $args ) {

	$el_keys = wp_list_pluck( $elements, 'db_id' );
	$el_keys = array_flip( $el_keys );
	foreach ( $elements as $element ) {

		if ( $element->menu_item_parent == 0 ) {

			$children_items = array();
			foreach ( $elements as $s_element ) {
				if ( $element->db_id == $s_element->menu_item_parent ) {
					$children_items[] = $s_element;
				}
			}

			$count = count( $children_items );

			if ( $count > 0 ) {
				$col_count = (int) ceil( count( $children_items ) / 2 );
				for ( $i = 0; $i < $count; $i ++ ) {

					$elements[ $el_keys[ $children_items[ $i ]->db_id ] ]->group_start = 0 === $i || $i === $col_count ? true : false;
					$elements[ $el_keys[ $children_items[ $i ]->db_id ] ]->group_end   = $i === $col_count - 1 || $i === $count - 1 ? true : false;

				}
			}
		} else {
			$children_items = array();
			foreach ( $elements as $s_element ) {
				if ( $element->db_id == $s_element->menu_item_parent ) {
					$children_items[] = $s_element;
				}
			}

			$count = count( $children_items );

			if ( $count > 0 ) {
				$elements[ $el_keys[ intval( $element->menu_item_parent ) ] ]->children = $children_items;
			}
			//$menu_elements[] = $element;

		}

	}

	return $elements;
}

add_filter( 'wp_nav_menu_objects', 'group_sub_menu_objects', 11, 2 );

function mod_settings_field( $field, $name, $settings ) {
	return $field;
}

add_filter( 'fl_builder_render_settings_field', 'mod_settings_field', 10, 3 );

function mod_settings_form( $form ) {
	if ( 'Heading Settings' == $form['title'] ) {
		$form['tabs']['advanced']['sections']['css_selectors']['fields']['class']['connections'] = array( 'string' );
	}

	return $form;
}

add_filter( 'fl_builder_settings_form_config', 'mod_settings_form' );

function ddp_get_page_color() {
	global $post;

	if ( is_object( $post ) ) {
		$parent_id       = $post->post_parent;
		$current_post_id = $post->ID;
	} elseif ( is_array( $post ) ) {
		$parent_id       = $post['post_parent'];
		$current_post_id = $post['ID'];
	} else {
		$parent_id       = 0;
		$current_post_id = $post;
	}

	if ( get_queried_object_id() === $current_post_id || is_archive() ) {
		if ( $parent_id != 0 ) {
			$current_post_id = get_top_parent_id( $post );
		}
		$color = get_post_meta( $current_post_id, 'page_color', true );
		$color = ! empty( $color ) ? esc_attr( $color ) : 'color-2';
	} else {
		global $wp;
		$current_url     = $wp->request;
		$topParentPost   = get_page_by_path( $current_url );
		$current_post_id = get_top_parent_id( $topParentPost );
		$color           = $current_post_id ? get_post_meta( $current_post_id, 'page_color', true ) : '';
		$color           = ! empty( $color ) ? esc_attr( $color ) : 'color-2';
	}

	return $color;
}

add_shortcode( 'ddp_page_color', 'ddp_get_page_color' );


/**
 * Function: get_top_parent_id
 */

function get_top_parent_id( $current_page ) {

	if ( ! $current_page ) {
		return false;
	}

	$ancestors     = get_ancestors( $current_page->ID, 'page' );
	$top_parent_id = $current_page->ID;

	if ( ! empty( $ancestors ) ) {
		//last entry in the array is the top parent
		$top_parent_id = $ancestors[ ( count( $ancestors ) - 1 ) ];
	}

	return $top_parent_id;
}

function manually_enqueue_jp_twitter_js( $node ) {
	if ( 'widget' === $node->slug && isset( $node->settings->widget ) && 'Jetpack_Twitter_Timeline_Widget' === $node->settings->widget ) {
		wp_enqueue_script( 'jetpack-twitter-timeline' );
	}
}

add_action( 'fl_builder_after_render_module', 'manually_enqueue_jp_twitter_js', 10 );

function ddp_menu_js() {

	/**
	 * If WP is in script debug, or we pass ?script_debug in a URL - set debug to true.
	 */
	$debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG == true ) || ( isset( $_GET['script_debug'] ) ) ? true : false;

	/**
	 * If we are debugging the site, use a unique version every page load so as to ensure no cache issues.
	 */
	$version = '1.0.0.9';

	/**
	 * Should we load minified files?
	 */
	$suffix = ( true === $debug ) ? '' : '.min';

	wp_enqueue_script( 'ddp-menu', get_stylesheet_directory_uri() . '/assets/js/menu' . $suffix . '.js', array( 'jquery' ), $version, true );
}

add_action( 'wp_enqueue_scripts', 'ddp_menu_js' );

function add_layout_to_body_class( $classes ) {

	$layout_ids = array();

	if ( is_archive() ) {
		$layout_ids = array_merge( FLThemeBuilderLayoutData::get_current_page_layout_ids( 'archive' ), $layout_ids );
	}

	if ( is_singular() ) {
		$layout_ids = array_merge( FLThemeBuilderLayoutData::get_current_page_layout_ids( 'singular' ), $layout_ids );
	}
	foreach ( $layout_ids as $id ) {
		$classes[] = "fl-theme-builder-" . sanitize_title( get_the_title( $id ) );
	}

	return $classes;
}

add_filter( 'body_class', 'add_layout_to_body_class' );

function add_color_to_body_class( $classes ) {

	global $post;

	if ( is_object( $post ) ) {
		$parent_id       = $post->post_parent;
		$current_post_id = $post->ID;
	} elseif ( is_array( $post ) ) {
		$parent_id       = $post['post_parent'];
		$current_post_id = $post['ID'];
	} else {
		$parent_id       = 0;
		$current_post_id = $post;
	}

	if ( get_queried_object_id() === $current_post_id || is_archive() ) {
		if ( $parent_id != 0 ) {
			$current_post_id = get_top_parent_id( $post );
		}
		$color = get_post_meta( $current_post_id, 'page_color', true );
		$color = ! empty( $color ) ? esc_attr( $color ) : 'color-2';
	} else {
		global $wp;
		$current_url     = $wp->request;
		$topParentPost   = get_page_by_path( $current_url );
		$current_post_id = get_top_parent_id( $topParentPost );
		$color           = $current_post_id ? get_post_meta( $current_post_id, 'page_color', true ) : '';
		$color           = ! empty( $color ) ? esc_attr( $color ) : 'color-2';
	}

	$classes[] = 'ddp--page-' . $color;

	return $classes;
}

add_filter( 'body_class', 'add_color_to_body_class' );

function add_social_menu_to_main_nav( $sorted_menu_items, $args ) {
	if ( 'main' === $args->menu ) {
		$sorted_menu_items[ count( $sorted_menu_items ) ]->last_item = $sorted_menu_items[ count( $sorted_menu_items ) ]->menu_item_parent;
	}

	return $sorted_menu_items;
}

add_filter( 'wp_nav_menu_objects', 'add_social_menu_to_main_nav', 10, 2 );

add_action( 'init', 'customize_font_list' );
function customize_font_list() {

	$custom_fonts = array(
		'Avenir LT W01_45 Book1475508'  => array(
			'fallback' => 'Arial, sans-serif',
			'weights'  => array(
				'400',
				'700'
			)
		),
		'Avenir LT W01_85 Heavy1475544' => array(
			'fallback' => 'Arial, sans-serif',
			'weights'  => array(
				'400',
				'700'
			)
		),
		'Avenir LT W01_95 Black1475556' => array(
			'fallback' => 'Arial, sans-serif',
			'weights'  => array(
				'400',
				'700'
			)
		),
	);

	foreach ( $custom_fonts as $name => $settings ) {
		// Add to Theme Customizer
		if ( class_exists( 'FLFontFamilies' ) && isset( FLFontFamilies::$system ) ) {
			FLFontFamilies::$system[ $name ] = $settings;
		}

		// Add to Page Builder
		if ( class_exists( 'FLBuilderFontFamilies' ) && isset( FLBuilderFontFamilies::$system ) ) {
			FLBuilderFontFamilies::$system[ $name ] = $settings;
		}
	}
}

if ( ! function_exists( 'the_archive_title' ) ) :
	/**
	 * Shim for `the_archive_title()`.
	 *
	 * Display the archive title based on the queried object.
	 *
	 * @todo Remove this function when WordPress 4.3 is released.
	 *
	 * @param string $before Optional. Content to prepend to the title. Default empty.
	 * @param string $after Optional. Content to append to the title. Default empty.
	 */
	function the_archive_title( $before = '', $after = '' ) {
		if ( is_category() ) {
			$title = sprintf( esc_html__( 'Articles in Category: %s', 'fl-child-theme' ), single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( esc_html__( 'Articles in Tag: %s', 'fl-child-theme' ), single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( esc_html__( 'Articles by Author: %s', 'fl-child-theme' ), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( esc_html__( 'Articles from Year: %s', 'fl-child-theme' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'fl-child-theme' ) ) );
		} elseif ( is_month() ) {
			$title = sprintf( esc_html__( 'Articles from Month: %s', 'fl-child-theme' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'fl-child-theme' ) ) );
		} elseif ( is_day() ) {
			$title = sprintf( esc_html__( 'Articles from Day: %s', 'fl-child-theme' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'fl-child-theme' ) ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = esc_html_x( 'Asides', 'post format archive title', 'fl-child-theme' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = esc_html_x( 'Galleries', 'post format archive title', 'fl-child-theme' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = esc_html_x( 'Images', 'post format archive title', 'fl-child-theme' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = esc_html_x( 'Videos', 'post format archive title', 'fl-child-theme' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = esc_html_x( 'Quotes', 'post format archive title', 'fl-child-theme' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = esc_html_x( 'Links', 'post format archive title', 'fl-child-theme' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = esc_html_x( 'Statuses', 'post format archive title', 'fl-child-theme' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = esc_html_x( 'Audio', 'post format archive title', 'fl-child-theme' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = esc_html_x( 'Chats', 'post format archive title', 'fl-child-theme' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = sprintf( esc_html__( 'Articles from the Archives: %s', 'fl-child-theme' ), post_type_archive_title( '', false ) );
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
			$title = sprintf( esc_html__( 'Articles in %1$s: %2$s', 'fl-child-theme' ), $tax->labels->singular_name, single_term_title( '', false ) );
		} else {
			$title = esc_html__( 'Archives', 'fl-child-theme' );
		}

		/**
		 * Filter the archive title.
		 *
		 * @param string $title Archive title to be displayed.
		 */
		$title = apply_filters( 'get_the_archive_title', $title );

		if ( ! empty( $title ) ) {
			echo $before . $title . $after;  // WPCS: XSS OK.
		}
	}
endif;

function ev_unregister_taxonomy() {
	register_taxonomy( 'post_tag', array( 'post' ) );
}

add_action( 'init', 'ev_unregister_taxonomy', 10000 );

add_action( 'fl_page_data_add_properties', function () {

	FLPageData::add_group( 'ddp_events', array(
		'label' => 'DDP Events'
	) );

	FLPageData::add_post_property( 'ddp_organizer_name', array(
		'label'  => 'Event Organizer Name',
		'group'  => 'ddp_events',
		'type'   => 'string',
		'getter' => 'get_ddp_organizer_name'
	) );

	FLPageData::add_post_property( 'ddp_organizer_phone', array(
		'label'  => 'Event Organizer Phone',
		'group'  => 'ddp_events',
		'type'   => 'string',
		'getter' => 'get_ddp_organizer_phone'
	) );

	FLPageData::add_post_property( 'ddp_organizer_website', array(
		'label'  => 'Event Organizer URL',
		'group'  => 'ddp_events',
		'type'   => 'string',
		'getter' => 'get_ddp_organizer_website'
	) );

	FLPageData::add_post_property( 'ddp_venue_name', array(
		'label'  => 'Event Venue Name',
		'group'  => 'ddp_events',
		'type'   => 'string',
		'getter' => 'get_ddp_venue_name'
	) );

	FLPageData::add_post_property( 'ddp_venue_address', array(
		'label'  => 'Event Venue Address',
		'group'  => 'ddp_events',
		'type'   => 'string',
		'getter' => 'get_ddp_venue_address'
	) );

	FLPageData::add_post_property( 'ddp_venue_city', array(
		'label'  => 'Event Venue City',
		'group'  => 'ddp_events',
		'type'   => 'string',
		'getter' => 'get_ddp_venue_city'
	) );

	FLPageData::add_post_property( 'ddp_venue_country', array(
		'label'  => 'Event Venue Country',
		'group'  => 'ddp_events',
		'type'   => 'string',
		'getter' => 'get_ddp_venue_country'
	) );

	FLPageData::add_post_property( 'ddp_venue_state', array(
		'label'  => 'Event Venue State',
		'group'  => 'ddp_events',
		'type'   => 'string',
		'getter' => 'get_ddp_venue_state'
	) );

	FLPageData::add_post_property( 'ddp_venue_zip', array(
		'label'  => 'Event Venue Zip',
		'group'  => 'ddp_events',
		'type'   => 'string',
		'getter' => 'get_ddp_venue_zip'
	) );

	FLPageData::add_post_property( 'ddp_venue_phone', array(
		'label'  => 'Event Venue Phone',
		'group'  => 'ddp_events',
		'type'   => 'string',
		'getter' => 'get_ddp_venue_phone'
	) );

	FLPageData::add_post_property( 'ddp_venue_url', array(
		'label'  => 'Event Venue URL',
		'group'  => 'ddp_events',
		'type'   => 'string',
		'getter' => 'get_ddp_venue_url'
	) );
} );

function get_ddp_organizer_name() {
	global $post;

	$post_id = ddp_get_post_id($post);
	$organizer_id = get_post_meta($post_id, '_EventOrganizerID', true);
	$name = get_post_meta($organizer_id, '_OrganizerOrganizer', true);

	return $name;
}

function get_ddp_organizer_phone() {
	global $post;

	$post_id = ddp_get_post_id($post);
	$organizer_id = get_post_meta($post_id, '_EventOrganizerID', true);
	$phone = get_post_meta($organizer_id, '_OrganizerPhone', true);

	return $phone;
}

function get_ddp_organizer_website() {
	global $post;

	$post_id = ddp_get_post_id($post);
	$organizer_id = get_post_meta($post_id, '_EventOrganizerID', true);
	$url = get_post_meta($organizer_id, '_OrganizerWebsite', true);

	return $url;
}

function get_ddp_venue_name() {
	global $post;

	$post_id = ddp_get_post_id($post);
	$venue_id = get_post_meta($post_id, '_EventVenueID', true);
	$name = get_post_meta($venue_id, '_VenueVenue', true);

	return $name;
}

function get_ddp_venue_address() {
	global $post;

	$post_id = ddp_get_post_id($post);
	$venue_id = get_post_meta($post_id, '_EventVenueID', true);
	$address = get_post_meta($venue_id, '_VenueAddress', true);

	return $address;
}

function get_ddp_venue_city() {
	global $post;

	$post_id = ddp_get_post_id($post);
	$venue_id = get_post_meta($post_id, '_EventVenueID', true);
	$name = get_post_meta($venue_id, '_VenueCity', true);

	return $name;
}

function get_ddp_venue_country() {
	global $post;

	$post_id = ddp_get_post_id($post);
	$venue_id = get_post_meta($post_id, '_EventVenueID', true);
	$name = get_post_meta($venue_id, '_VenueCountry', true);

	return $name;
}

function get_ddp_venue_state() {
	global $post;

	$post_id = ddp_get_post_id($post);
	$venue_id = get_post_meta($post_id, '_EventVenueID', true);
	$name = get_post_meta($venue_id, '_VenueState', true);

	return $name;
}

function get_ddp_venue_zip() {
	global $post;

	$post_id = ddp_get_post_id($post);
	$venue_id = get_post_meta($post_id, '_EventVenueID', true);
	$name = get_post_meta($venue_id, '_VenueZip', true);

	return $name;
}

function get_ddp_venue_phone() {
	global $post;

	$post_id = ddp_get_post_id($post);
	$venue_id = get_post_meta($post_id, '_EventVenueID', true);
	$name = get_post_meta($venue_id, '_VenuePhone', true);

	return $name;
}

function get_ddp_venue_url() {
	global $post;

	$post_id = ddp_get_post_id($post);
	$venue_id = get_post_meta($post_id, '_EventVenueID', true);
	$name = get_post_meta($venue_id, '_VenueURL', true);

	return $name;
}

function ddp_get_post_id( $post ) {

	if ( is_object( $post ) ) {
		$current_post_id = $post->ID;
	} elseif ( is_array( $post ) ) {
		$current_post_id = $post['ID'];
	} else {
		$current_post_id = is_numeric($post) ? $post : 0;
	}

	return $current_post_id;

}