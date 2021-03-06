<?php

function uabb_column_render_css(  ) {

    $module = UABB_Init::$uabb_options['fl_builder_uabb'];
    $col_grad = isset( $module["uabb-col-gradient"] ) ? $module["uabb-col-gradient"] : true;
    if( $col_grad ) {
        add_filter( 'fl_builder_render_css', 'uabb_column_gradient_css', 10, 3 );
    }

    $col_shadow = isset( $module["uabb-col-shadow"] ) ? $module["uabb-col-shadow"] : true;
    if( $col_shadow ) {
        add_filter( 'fl_builder_render_css', 'uabb_column_shadow_css', 10, 3 );
    }
}

function uabb_column_gradient_css( $css, $nodes, $global_settings ) {

    foreach ( $nodes['columns'] as $column ) {

        $column->settings->uabb_col_linear_gradient_primary_loc = ( isset($column->settings->uabb_col_linear_gradient_primary_loc) && $column->settings->uabb_col_linear_gradient_primary_loc != '' ) ? $column->settings->uabb_col_linear_gradient_primary_loc : 0;
        $column->settings->uabb_col_linear_gradient_secondary_loc = ( isset($column->settings->uabb_col_linear_gradient_secondary_loc) && $column->settings->uabb_col_linear_gradient_secondary_loc != '' ) ? $column->settings->uabb_col_linear_gradient_secondary_loc : 100;
        $column->settings->uabb_col_radial_gradient_primary_loc = ( isset($column->settings->uabb_col_radial_gradient_primary_loc) && $column->settings->uabb_col_radial_gradient_primary_loc != '' ) ? $column->settings->uabb_col_radial_gradient_primary_loc : 0;
        $column->settings->uabb_col_radial_gradient_secondary_loc = ( isset($column->settings->uabb_col_radial_gradient_secondary_loc) && $column->settings->uabb_col_radial_gradient_secondary_loc != '' ) ? $column->settings->uabb_col_radial_gradient_secondary_loc : 100;
        ob_start();

        if( isset( $column->settings->uabb_col_radial_direction ) ) {
            $column->settings->uabb_col_radial_direction = str_replace("_"," ",$column->settings->uabb_col_radial_direction);
        }

        switch ( $column->settings->uabb_col_uabb_direction ) {
            case 'top':
                $column->settings->uabb_col_linear_direction = '0';
                break;
            case 'bottom':
                $column->settings->uabb_col_linear_direction = '180';
                break;
            case 'left':
                $column->settings->uabb_col_linear_direction = '90';
                break;
            case 'right':
                $column->settings->uabb_col_linear_direction = '270';
                break;
            case 'top_right_diagonal':
                $column->settings->uabb_col_linear_direction = '45';
                break;
            case 'top_left_diagonal':
                $column->settings->uabb_col_linear_direction = '315';
                break;
            case 'bottom_right_diagonal':
                $column->settings->uabb_col_linear_direction = '135';
                break;
            case 'bottom_left_diagonal':
                $column->settings->uabb_col_linear_direction = '255';
                break;
        }

        if( $column->settings->uabb_col_linear_advance_options == 'no' ) {
            $column->settings->uabb_col_linear_gradient_primary_loc   = '0';
            $column->settings->uabb_col_linear_gradient_secondary_loc = '100';
        }
        if( $column->settings->uabb_col_radial_advance_options == 'no' ) {
            $column->settings->uabb_col_radial_gradient_primary_loc   = '0';
            $column->settings->uabb_col_radial_gradient_secondary_loc = '100';
        }

        if( $column->settings->uabb_col_linear_direction == '' ) {
            $column->settings->uabb_col_linear_direction   = '0';
        }
         
        if ( isset( $column->settings->bg_type ) && 'uabb_gradient' == $column->settings->bg_type ) {
            ?>

            <?php if ( $column->settings->uabb_col_gradient_type == 'linear' ) { ?>
                .fl-node-<?php echo $column->node; ?> > .fl-col-content {
                    background-color: #<?php echo $column->settings->uabb_col_gradient_primary_color; ?>;
                    background-image: -webkit-linear-gradient(<?php echo $column->settings->uabb_col_linear_direction . 'deg'; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_primary_color; ?> <?php echo $column->settings->uabb_col_linear_gradient_primary_loc . '%' ; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_secondary_color; ?> <?php echo $column->settings->uabb_col_linear_gradient_secondary_loc . '%' ; ?>);
                    background-image: -moz-linear-gradient(<?php echo $column->settings->uabb_col_linear_direction . 'deg'; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_primary_color; ?> <?php echo $column->settings->uabb_col_linear_gradient_primary_loc . '%' ; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_secondary_color; ?> <?php echo $column->settings->uabb_col_linear_gradient_secondary_loc . '%' ; ?>);
                    background-image: -o-linear-gradient(<?php echo $column->settings->uabb_col_linear_direction . 'deg'; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_primary_color; ?> <?php echo $column->settings->uabb_col_linear_gradient_primary_loc . '%' ; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_secondary_color; ?> <?php echo $column->settings->uabb_col_linear_gradient_secondary_loc . '%' ; ?>);
                    background-image: -ms-linear-gradient(<?php echo $column->settings->uabb_col_linear_direction . 'deg'; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_primary_color; ?> <?php echo $column->settings->uabb_col_linear_gradient_primary_loc . '%' ; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_secondary_color; ?> <?php echo $column->settings->uabb_col_linear_gradient_secondary_loc . '%' ; ?>);
                    background-image: linear-gradient(<?php echo $column->settings->uabb_col_linear_direction . 'deg'; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_primary_color; ?> <?php echo $column->settings->uabb_col_linear_gradient_primary_loc . '%' ; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_secondary_color; ?> <?php echo $column->settings->uabb_col_linear_gradient_secondary_loc . '%' ; ?>);
                }
            <?php } ?>
            <?php if ( $column->settings->uabb_col_gradient_type == 'radial' ) { ?>
                .fl-node-<?php echo $column->node; ?> > .fl-col-content {
                    background-color: #<?php echo $column->settings->uabb_col_gradient_primary_color; ?>;
                    background-image: -webkit-radial-gradient(<?php echo 'at ' . $column->settings->uabb_col_radial_direction ?>, <?php echo '#'.$column->settings->uabb_col_gradient_primary_color; ?> <?php echo $column->settings->uabb_col_radial_gradient_primary_loc . '%' ; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_secondary_color; ?> <?php echo $column->settings->uabb_col_radial_gradient_secondary_loc . '%' ; ?>);
                    background-image: -moz-radial-gradient(<?php echo 'at ' . $column->settings->uabb_col_radial_direction ?>, <?php echo '#'.$column->settings->uabb_col_gradient_primary_color; ?> <?php echo $column->settings->uabb_col_radial_gradient_primary_loc . '%' ; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_secondary_color; ?> <?php echo $column->settings->uabb_col_radial_gradient_secondary_loc . '%' ; ?>);
                    background-image: -o-radial-gradient(<?php echo 'at ' . $column->settings->uabb_col_radial_direction ?>, <?php echo '#'.$column->settings->uabb_col_gradient_primary_color; ?> <?php echo $column->settings->uabb_col_radial_gradient_primary_loc . '%' ; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_secondary_color; ?> <?php echo $column->settings->uabb_col_radial_gradient_secondary_loc . '%' ; ?>);
                    background-image: -ms-radial-gradient(<?php echo 'at ' . $column->settings->uabb_col_radial_direction ?>, <?php echo '#'.$column->settings->uabb_col_gradient_primary_color; ?> <?php echo $column->settings->uabb_col_radial_gradient_primary_loc . '%' ; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_secondary_color; ?> <?php echo $column->settings->uabb_col_radial_gradient_secondary_loc . '%' ; ?>);
                    background-image: radial-gradient(<?php echo 'at ' . $column->settings->uabb_col_radial_direction ?>, <?php echo '#'.$column->settings->uabb_col_gradient_primary_color; ?> <?php echo $column->settings->uabb_col_radial_gradient_primary_loc . '%' ; ?>, <?php echo '#'.$column->settings->uabb_col_gradient_secondary_color; ?> <?php echo $column->settings->uabb_col_radial_gradient_secondary_loc . '%' ; ?>);
                }
            <?php } ?>
        <?php } ?>
    <?php
        $css .= ob_get_clean();
    }

    return $css;
}

function uabb_column_shadow_css( $css, $nodes, $global_settings ) {

    foreach ( $nodes['columns'] as $column ) {

        ob_start();
        ?>
            <?php if ( 'yes' == $column->settings->col_drop_shadow ) { ?>
                .fl-node-<?php echo $column->node; ?> > .fl-col-content.fl-node-content {
                    -webkit-box-shadow: <?php echo $column->settings->col_shadow_color_hor; ?>px <?php echo $column->settings->col_shadow_color_ver; ?>px <?php echo $column->settings->col_shadow_color_blur; ?>px <?php echo $column->settings->col_shadow_color_spr; ?>px <?php echo ( false === strpos( $column->settings->col_shadow_color, 'rgb' ) ) ? '#' . $column->settings->col_shadow_color : $column->settings->col_shadow_color; ?>;
                    -moz-box-shadow: <?php echo $column->settings->col_shadow_color_hor; ?>px <?php echo $column->settings->col_shadow_color_ver; ?>px <?php echo $column->settings->col_shadow_color_blur; ?>px <?php echo $column->settings->col_shadow_color_spr; ?>px <?php echo ( false === strpos( $column->settings->col_shadow_color, 'rgb' ) ) ? '#' . $column->settings->col_shadow_color : $column->settings->col_shadow_color; ?>;
                    -o-box-shadow: <?php echo $column->settings->col_shadow_color_hor; ?>px <?php echo $column->settings->col_shadow_color_ver; ?>px <?php echo $column->settings->col_shadow_color_blur; ?>px <?php echo $column->settings->col_shadow_color_spr; ?>px <?php echo ( false === strpos( $column->settings->col_shadow_color, 'rgb' ) ) ? '#' . $column->settings->col_shadow_color : $column->settings->col_shadow_color; ?>;
                    box-shadow: <?php echo $column->settings->col_shadow_color_hor; ?>px <?php echo $column->settings->col_shadow_color_ver; ?>px <?php echo $column->settings->col_shadow_color_blur; ?>px <?php echo $column->settings->col_shadow_color_spr; ?>px <?php echo ( false === strpos( $column->settings->col_shadow_color, 'rgb' ) ) ? '#' . $column->settings->col_shadow_color : $column->settings->col_shadow_color; ?>; 
                    <?php if( isset(  $column->settings->col_shadow_hover_transition ) && 'yes' == $column->settings->col_hover_shadow )  { ?>                   
                        -webkit-transition: -webkit-box-shadow <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out, -webkit-transform <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out;
                        -moz-transition: -moz-box-shadow <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out, -moz-transform <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out;
                        transition: box-shadow <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out, transform <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out;
                        will-change: box-shadow;
                    <?php } ?>
                }
            <?php } ?>

            <?php if ( 'yes' == $column->settings->col_hover_shadow ) { ?>
                .fl-node-<?php echo $column->node; ?> > .fl-col-content.fl-node-content:hover {
                    -webkit-box-shadow: <?php echo $column->settings->col_shadow_color_hor_hover; ?>px <?php echo $column->settings->col_shadow_color_ver_hover; ?>px <?php echo $column->settings->col_shadow_color_blur_hover; ?>px <?php echo $column->settings->col_shadow_color_spr_hover; ?>px <?php echo ( false === strpos( $column->settings->col_shadow_color_hover, 'rgb' ) ) ? '#' . $column->settings->col_shadow_color_hover : $column->settings->col_shadow_color_hover; ?>;
                    -moz-box-shadow: <?php echo $column->settings->col_shadow_color_hor_hover; ?>px <?php echo $column->settings->col_shadow_color_ver_hover; ?>px <?php echo $column->settings->col_shadow_color_blur_hover; ?>px <?php echo $column->settings->col_shadow_color_spr_hover; ?>px <?php echo ( false === strpos( $column->settings->col_shadow_color_hover, 'rgb' ) ) ? '#' . $column->settings->col_shadow_color_hover : $column->settings->col_shadow_color_hover; ?>;
                    -o-box-shadow: <?php echo $column->settings->col_shadow_color_hor_hover; ?>px <?php echo $column->settings->col_shadow_color_ver_hover; ?>px <?php echo $column->settings->col_shadow_color_blur_hover; ?>px <?php echo $column->settings->col_shadow_color_spr_hover; ?>px <?php echo ( false === strpos( $column->settings->col_shadow_color_hover, 'rgb' ) ) ? '#' . $column->settings->col_shadow_color_hover : $column->settings->col_shadow_color_hover; ?>;
                    box-shadow: <?php echo $column->settings->col_shadow_color_hor_hover; ?>px <?php echo $column->settings->col_shadow_color_ver_hover; ?>px <?php echo $column->settings->col_shadow_color_blur_hover; ?>px <?php echo $column->settings->col_shadow_color_spr_hover; ?>px <?php echo ( false === strpos( $column->settings->col_shadow_color_hover, 'rgb' ) ) ? '#' . $column->settings->col_shadow_color_hover : $column->settings->col_shadow_color_hover; ?>;                    
                    <?php if( isset(  $column->settings->col_shadow_hover_transition ) && 'yes' == $column->settings->col_hover_shadow )  { ?>                   
                        -webkit-transition: -webkit-box-shadow <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out, -webkit-transform <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out;
                        -moz-transition: -moz-box-shadow <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out, -moz-transform <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out;
                        transition: box-shadow <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out, transform <?php echo $column->settings->col_shadow_hover_transition; ?>ms ease-in-out;
                        will-change: box-shadow;
                    <?php } ?>
                }
            <?php } ?>

            <?php if(  $column->settings->col_responsive_shadow == 'yes' && 'yes' == $column->settings->col_drop_shadow ) { ?>
                @media only screen and (max-width: <?php echo $global_settings->medium_breakpoint; ?>px) {
                    .fl-node-<?php echo $column->node; ?> .fl-col-content.fl-node-content {
                        box-shadow: none;
                    }
                }
            <?php } ?>

            <?php if(  $column->settings->col_responsive_shadow == 'no' && $column->settings->col_small_shadow == 'yes' && 'yes' == $column->settings->col_drop_shadow ) { ?>
                @media only screen and (max-width: <?php echo $global_settings->responsive_breakpoint; ?>px) {
                    .fl-node-<?php echo $column->node; ?> .fl-col-content.fl-node-content {
                        box-shadow: none;
                    }
                }
            <?php } ?>

    <?php
        $css .= ob_get_clean();
    }

    return $css;
}