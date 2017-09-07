<?php
/**
 *  UABB Advanced Menu Walker
 *
 *  Helper functions, actions & filter hooks etc.
 */

class Creative_Menu_Walker extends Walker_Nav_Menu {

	function __construct( $settings ) {
        $this->param = $settings;
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $args   = ( object )$args;

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $submenu = $args->has_children ? ' uabb-has-submenu' : '';
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = ' class="' . esc_attr( $class_names ) . $submenu . ' uabb-creative-menu uabb-cm-style"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names . '>';

        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

        $item_output = $args->has_children ? '<div class="uabb-has-submenu-container">' : '';
        $item_output .= $args->before;
        $item_output .= '<a'. $attributes . ' data-hover="'	. trim( $item->title, '' ) . '"><span class="menu-item-text" data-hover="'	. trim( $item->title, '' ) .'">';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if( $args->has_children ) {
			$item_output .= '<span class="uabb-menu-toggle"></span>';
		}
        $item_output .= '</span></a>';

        $item_output .= $args->after;
        $item_output .= $args->has_children ? '</div>' : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

    }

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}
?>