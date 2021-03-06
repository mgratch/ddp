<?php 
    global $post;
    $converted = get_post_meta( $post->ID,'_uabb_converted', true );

	$settings->form_bg_color = UABB_Helper::uabb_colorpicker( $settings, 'form_bg_color', true );
    $settings->input_background_color = UABB_Helper::uabb_colorpicker( $settings, 'input_background_color', true );
    $settings->input_border_color = UABB_Helper::uabb_colorpicker( $settings, 'input_border_color' );
    $settings->input_border_active_color = UABB_Helper::uabb_colorpicker( $settings, 'input_border_active_color' );
    
    $settings->btn_text_color = UABB_Helper::uabb_colorpicker( $settings, 'btn_text_color' );
    $settings->btn_text_hover_color = UABB_Helper::uabb_colorpicker( $settings, 'btn_text_hover_color' );
    $settings->btn_background_color = UABB_Helper::uabb_colorpicker( $settings, 'btn_background_color', true );
    $settings->btn_background_hover_color = UABB_Helper::uabb_colorpicker( $settings, 'btn_background_hover_color', true );

    /* Typography Colors */

    $settings->form_title_color = UABB_Helper::uabb_colorpicker( $settings, 'form_title_color' );
    $settings->form_desc_color = UABB_Helper::uabb_colorpicker( $settings, 'form_desc_color' );
    
    $settings->label_color = UABB_Helper::uabb_colorpicker( $settings, 'label_color' );
    /* Input Color */
    $settings->color = UABB_Helper::uabb_colorpicker( $settings, 'color' );
    
    $settings->input_msg_color = UABB_Helper::uabb_colorpicker( $settings, 'input_msg_color' );
    $settings->validation_msg_color = UABB_Helper::uabb_colorpicker( $settings, 'validation_msg_color' );
    $settings->validation_bg_color = UABB_Helper::uabb_colorpicker( $settings, 'validation_bg_color', true );
    
    $settings->validation_border_color = UABB_Helper::uabb_colorpicker( $settings, 'validation_border_color' );
    $settings->radio_check_size = ( $settings->radio_check_size != '' ) ? $settings->radio_check_size : 20;
    $settings->radio_check_border_width = ( $settings->radio_check_border_width != '' ) ? $settings->radio_check_border_width : 1;
    $settings->radio_btn_border_radius = ( $settings->radio_btn_border_radius != '' ) ? $settings->radio_btn_border_radius : 50;
    $settings->checkbox_border_radius = ( $settings->checkbox_border_radius != '' ) ? $settings->checkbox_border_radius : 0;
    $settings->input_msg_font_size = ( $settings->input_msg_font_size != '' ) ? $settings->input_msg_font_size : 12;
    $settings->validation_msg_font_size = ( $settings->validation_msg_font_size != '' ) ? $settings->validation_msg_font_size : 15;
    $settings->validation_border_width = ( $settings->validation_border_width != '' ) ? $settings->validation_border_width : 1;
    $settings->input_success_msg_font_size = ( $settings->input_success_msg_font_size != '' ) ? $settings->input_success_msg_font_size : 15;
    $settings->input_top_margin = ( $settings->input_top_margin != '' ) ? $settings->input_top_margin : 10;
    $settings->input_bottom_margin = ( $settings->input_bottom_margin != '' ) ? $settings->input_bottom_margin : 15;
    $settings->input_desc_font_size = ( $settings->input_desc_font_size != '' ) ? $settings->input_desc_font_size : 12;
?>
.fl-node-<?php echo $id; ?> {
    width: 100%;
}

/* Form Style */
.fl-node-<?php echo $id; ?> .uabb-gf-style {

	<?php if ( $settings->form_bg_type == 'color' ) { ?>
		background-color: <?php echo $settings->form_bg_color; ?>;
	<?php }elseif ( $settings->form_bg_type == 'image' && isset( FLBuilderPhoto::get_attachment_data($settings->form_bg_img)->url ) ) { ?>
		background-image: url(<?php echo FLBuilderPhoto::get_attachment_data($settings->form_bg_img)->url; ?>);
		background-position: <?php echo $settings->form_bg_img_pos; ?>;
		background-size: <?php echo $settings->form_bg_img_size; ?>;
		background-repeat: <?php echo $settings->form_bg_img_repeat; ?>;
	<?php }elseif( $settings->form_bg_type == 'gradient' ) { ?>
		<?php UABB_Helper::uabb_gradient_css( $settings->form_bg_gradient ); ?>
	<?php } ?>

    <?php 
    if( $converted === 'yes' || isset($settings->form_spacing_dimension_top) && isset( $settings->form_spacing_dimension_bottom )   && isset( $settings->form_spacing_dimension_left ) && isset( $settings->form_spacing_dimension_right ) ) {
        if(isset($settings->form_spacing_dimension_top) ){
            echo ( $settings->form_spacing_dimension_top != '' ) ? 'padding-top:'.$settings->form_spacing_dimension_top.'px;' : 'padding-top: 20px;'; 
        }
        if(isset($settings->form_spacing_dimension_bottom) ){
            echo ( $settings->form_spacing_dimension_bottom != '' ) ? 'padding-bottom:'.$settings->form_spacing_dimension_bottom.'px;' : 'padding-bottom: 20px;';
        }
        if(isset($settings->form_spacing_dimension_left) ){
            echo ( $settings->form_spacing_dimension_left != '' ) ? 'padding-left:'.$settings->form_spacing_dimension_left.'px;' : 'padding-left: 20px;';
        }
        if(isset($settings->form_spacing_dimension_right) ){
            echo ( $settings->form_spacing_dimension_right != '' ) ? 'padding-right:'.$settings->form_spacing_dimension_right.'px;' : 'padding-right: 20px;';
        } 
    } else if( isset( $settings->form_spacing ) && $settings->form_spacing != '' && isset( $settings->form_spacing_dimension_top ) && $settings->form_spacing_dimension_top == '' && isset( $settings->form_spacing_dimension_bottom ) && $settings->form_spacing_dimension_bottom == ''  && isset( $settings->form_spacing_dimension_left ) && $settings->form_spacing_dimension_left == ''  && isset( $settings->form_spacing_dimension_right ) && $settings->form_spacing_dimension_right == '' ) {
        echo $settings->form_spacing; ?>;
    <?php } ?>

	<?php if ( $settings->form_radius != ''  ) { ?>
		border-radius:<?php echo $settings->form_radius; ?>px;
	<?php } ?>


}

/* Input Fields CSS */

.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper form .gform_body input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
.fl-node-<?php echo $id; ?> .gform_wrapper textarea,
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield .ginput_container select {

    <?php 
    if( $converted === 'yes' || isset($settings->input_padding_dimension_top) && isset( $settings->input_padding_dimension_bottom ) && isset( $settings->input_padding_dimension_left ) && isset( $settings->input_padding_dimension_right )  ) {
        if(isset($settings->input_padding_dimension_top) ){
            echo ( $settings->input_padding_dimension_top != '' ) ? 'padding-top:'.$settings->input_padding_dimension_top.'px;' : 'padding-top: 15px;'; 
        }
        if(isset($settings->input_padding_dimension_bottom) ){
            echo ( $settings->input_padding_dimension_bottom != '' ) ? 'padding-bottom:'.$settings->input_padding_dimension_bottom.'px;' : 'padding-bottom: 15px;';
        }
        if(isset($settings->input_padding_dimension_left) ){
            echo ( $settings->input_padding_dimension_left != '' ) ? 'padding-left:'.$settings->input_padding_dimension_left.'px;' : 'padding-left: 15px;';
        }
        if(isset($settings->input_padding_dimension_right) ){
            echo ( $settings->input_padding_dimension_right != '' ) ? 'padding-right:'.$settings->input_padding_dimension_right.'px;' : 'padding-right: 15px;';
        } 
    } else if( isset( $settings->input_padding ) && $settings->input_padding != '' && isset( $settings->input_padding_dimension_top ) && $settings->input_padding_dimension_top == '' && isset( $settings->input_padding_dimension_bottom ) && $settings->input_padding_dimension_bottom == ''  && isset( $settings->input_padding_dimension_left ) && $settings->input_padding_dimension_left == ''  && isset( $settings->input_padding_dimension_right ) && $settings->input_padding_dimension_right == '' ) {
        $settings->input_padding = ( isset( $settings->input_padding ) && $settings->input_padding != '' ) ? $settings->input_padding : 15;
        echo $settings->input_padding; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=tel],
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=email],
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=text],
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=url],
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=number],
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=date],
.fl-node-<?php echo $id; ?> .uabb-gf-style select,
.fl-node-<?php echo $id; ?> .uabb-gf-style textarea,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=tel]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=email]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=text]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=url]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=number]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=date]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style select:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style textarea:focus,
.gform_wrapper .ginput_container_select .chosen-container-single .chosen-single,
.chosen-container .chosen-container-single .chosen-container-active .chosen-with-drop,
.gform_wrapper .ginput_container_select .chosen-container-active.chosen-with-drop .chosen-single {
    <?php
    if( isset( $settings->input_border_radius ) ) { ?>
        border-radius: <?php echo $settings->input_border_radius; ?>px;
    <?php } ?>
    outline: none;
    line-height: 1.3;
    text-align: <?php echo $settings->input_text_align; ?>;
    color: <?php echo uabb_theme_text_color( $settings->color ); ?>;
    <?php
    $bgcolor = '';
    if ( $settings->input_background_type == 'color' ) {
        $bgcolor = ( $settings->input_background_color != '' ) ? $settings->input_background_color : '';
    } else {
        $bgcolor = 'transparent';
    }
    ?>
    background: <?php echo $bgcolor; ?>;
    border-style: solid;
    border-color: <?php echo uabb_theme_text_color( $settings->input_border_color ); ?>;

    <?php 
    if( $converted === 'yes' || isset($settings->input_border_width_dimension_top) && isset( $settings->input_border_width_dimension_bottom )  && isset( $settings->input_border_width_dimension_left )  && isset( $settings->input_border_width_dimension_right ) ) {
        if(isset($settings->input_border_width_dimension_top) ){
            echo ( $settings->input_border_width_dimension_top != '' ) ? 'border-top-width:'.$settings->input_border_width_dimension_top.'px;' : 'border-top-width: 1px;'; 
        }
        if(isset($settings->input_border_width_dimension_bottom) ){
            echo ( $settings->input_border_width_dimension_bottom != '' ) ? 'border-bottom-width:'.$settings->input_border_width_dimension_bottom.'px;' : 'border-bottom-width: 1px;';
        }
        if(isset($settings->input_border_width_dimension_left) ){
            echo ( $settings->input_border_width_dimension_left != '' ) ? 'border-left-width:'.$settings->input_border_width_dimension_left.'px;' : 'border-left-width: 1px;';
        }
        if(isset($settings->input_border_width_dimension_right) ){
            echo ( $settings->input_border_width_dimension_right != '' ) ? 'border-right-width:'.$settings->input_border_width_dimension_right.'px;' : 'border-right-width: 1px;';
        } 
    } else if( isset( $settings->uabb_input_border_width ) && is_array( $settings->uabb_input_border_width ) && isset( $settings->input_border_width_dimension_top ) && $settings->input_border_width_dimension_top == ''  && isset( $settings->input_border_width_dimension_bottom ) && $settings->input_border_width_dimension_bottom == '' && isset( $settings->input_border_width_dimension_left ) &&  $settings->input_border_width_dimension_left == '' && isset( $settings->input_border_width_dimension_right ) && $settings->input_border_width_dimension_right == '' ) { ?>
        <?php
            $str = '0;';
            if( is_array( $settings->uabb_input_border_width ) ) {
                if( $settings->uabb_input_border_width['simplify'] == 'collapse' ) {
                    $str = ( $settings->uabb_input_border_width['all'] != '' ) ? $settings->uabb_input_border_width['all'] . 'px;' : '1;';
                } else {
                    $str = ( $settings->uabb_input_border_width['top'] != '' ) ? $settings->uabb_input_border_width['top'] . 'px ' : '1 ';
                    $str .= ( $settings->uabb_input_border_width['right'] != '' ) ? $settings->uabb_input_border_width['right'] . 'px ' : '1 ';
                    $str .= ( $settings->uabb_input_border_width['bottom'] != '' ) ? $settings->uabb_input_border_width['bottom'] . 'px ' : '1 ';
                    $str .= ( $settings->uabb_input_border_width['left'] != '' ) ? $settings->uabb_input_border_width['left'] . 'px ' : '1;';
                }
            }
            ?>
            border-width: <?php echo $str; ?>
    <?php } ?>
}

<?php if( $settings->input_border_active_color != '' ) { ?>
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=tel]:active,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=tel]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=email]:active,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=email]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=text]:active,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=text]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=url]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=url]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=number]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=number]:active,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=date]:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=date]:active,
.fl-node-<?php echo $id; ?> .uabb-gf-style select:focus,
.fl-node-<?php echo $id; ?> .uabb-gf-style select:active,
.fl-node-<?php echo $id; ?> .uabb-gf-style textarea:active,
.fl-node-<?php echo $id; ?> .uabb-gf-style textarea:focus,
.gform_wrapper .chosen-container-active.chosen-with-drop .chosen-single,
.gform_wrapper .ginput_container_select .chosen-container-active.chosen-with-drop .chosen-single {
    border-color: <?php echo $settings->input_border_active_color; ?>;
}
<?php } ?>

.fl-node-<?php echo $id; ?> .gform_wrapper .gfield .gfield_description {
    <?php if( $settings->input_desc_font_size ) { ?>
        font-size: <?php echo $settings->input_desc_font_size; ?>px;
    <?php } ?>
    <?php if( $settings->input_description_color ) { ?>
        color: #<?php echo $settings->input_description_color; ?>;
    <?php } ?>
    <?php if( $settings->input_desc_line_height ) { ?>
        line-height: <?php echo $settings->input_desc_line_height; ?>px;
    <?php } ?>
    <?php if( $settings->label_font_family['family'] != 'Default' ) { ?>
        <?php FLBuilderFonts::font_css( $settings->label_font_family ); ?>
    <?php } ?>

    <?php if( $settings->input_desc_transform != '' ) ?>
       text-transform: <?php echo $settings->input_desc_transform; ?>;

    <?php if( $settings->input_desc_letter_spacing != '' ) ?>
       letter-spacing: <?php echo $settings->input_desc_letter_spacing; ?>px;
}

.fl-node-<?php echo $id; ?> .gform_wrapper .gfield .ginput_container span label {
    <?php if( $settings->label_color ) { ?>
    color: <?php echo $settings->label_color; ?>;
    <?php } ?>
    <?php if( $settings->label_font_family['family'] != 'Default' ) { ?>
    <?php FLBuilderFonts::font_css( $settings->label_font_family ); ?>
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_body .ginput_container_checkbox .gfield_checkbox li, 
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_body .ginput_container_radio .gfield_radio li {
    <?php if( $settings->input_text_align ) { ?>
    text-align: <?php echo $settings->input_text_align; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield_radio li label, 
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield_checkbox li label {
    <?php if( $settings->radio_check_custom_option == 'true' ) {?>
        <?php if( $settings->radio_checkbox_font_family['family'] != 'Default' ) { ?>
            <?php FLBuilderFonts::font_css( $settings->radio_checkbox_font_family ); ?>
        <?php } ?>

        <?php if( isset( $settings->radio_checkbox_font_size_unit ) && $settings->radio_checkbox_font_size_unit != '' ) : ?>
            font-size: <?php echo $settings->radio_checkbox_font_size_unit; ?>px;
        <?php endif; ?>
    
        <?php if( $settings->radio_checkbox_color ) { ?>
            color: #<?php echo $settings->radio_checkbox_color; ?>;
        <?php } ?>
    <?php } else if( $settings->radio_check_custom_option == 'false' ) { ?>     
        <?php if( $settings->label_font_family['family'] != "Default") : ?>
            <?php UABB_Helper::uabb_font_css( $settings->label_font_family ); ?>
        <?php endif; ?>

        <?php if( $settings->label_color != '' ) : ?>
            color: <?php echo $settings->label_color; ?>;
        <?php endif; ?>
    <?php } ?>

    <?php if( $settings->radio_checkbox_transform != '' ) ?>
       text-transform: <?php echo $settings->radio_checkbox_transform; ?>;

    <?php if( $settings->radio_checkbox_letter_spacing != '' ) ?>
       letter-spacing: <?php echo $settings->radio_checkbox_letter_spacing; ?>px;
}

<?php
if( $settings->radio_check_custom_option == 'true') { 
    $font_size = $settings->radio_check_size / 1.3;
    ?>
    .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_body .ginput_container_checkbox .gfield_checkbox input[type='checkbox'], 
    .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_body .ginput_container_radio .gfield_radio input[type='radio'] {
        display: none;
    }

    .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_body .ginput_container_checkbox .gfield_checkbox input[type='checkbox'] + label:before,
    .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_body .ginput_container_radio .gfield_radio input[type='radio'] + label:before {
        content: '';
        background: #<?php echo $settings->radio_check_bgcolor ?>;
        border: <?php echo $settings->radio_check_border_width ?>px solid #<?php echo $settings->radio_check_border_color ?>;
        display: inline-block;
        vertical-align: middle;
        width: <?php echo $settings->radio_check_size ?>px;
        height: <?php echo $settings->radio_check_size ?>px;
        padding: 2px;
        margin-right: 10px;
        text-align: center;
    }

    .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_body .ginput_container_checkbox .gfield_checkbox input[type='checkbox']:checked + label:before {
        content: "\2714";
        font-weight: bold;
        font-size: calc(<?php echo $font_size ?>px - <?php echo $settings->radio_check_border_width ?>px );
        padding-top: 0;
        color: #<?php echo $settings->radio_check_selected_color ?>;
    }

    .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_body .ginput_container_checkbox .gfield_checkbox input[type='checkbox'] + label:before {
        border-radius: <?php echo $settings->checkbox_border_radius ?>px;
    }

    .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_body .ginput_container_radio .gfield_radio input[type='radio']:checked + label:before {
        background: #<?php echo $settings->radio_check_selected_color ?>;
        box-shadow: inset 0px 0px 0px 4px #<?php echo $settings->radio_check_bgcolor ?>;
    }

    .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_body .ginput_container_radio .gfield_radio input[type='radio'] + label:before {
        border-radius: <?php echo $settings->radio_btn_border_radius ?>px;
    }

<?php 
} 
?>


<?php
/* Placeholder Colors  */
if( $settings->placeholder_color && $settings->input_placeholder_display == 'block' ) { ?>
    .fl-node-<?php echo $id; ?> .gform_wrapper .gfield input::-webkit-input-placeholder {
        color: #<?php echo $settings->placeholder_color; ?>;
    }
    .fl-node-<?php echo $id; ?> .gform_wrapper .gfield input:-moz-placeholder {
        color: #<?php echo $settings->placeholder_color; ?>;
    }
    .fl-node-<?php echo $id; ?> .gform_wrapper .gfield input::-moz-placeholder {
        color: #<?php echo $settings->placeholder_color; ?>;
    }
    .fl-node-<?php echo $id; ?> .gform_wrapper .gfield input:-ms-input-placeholder {
        color: #<?php echo $settings->placeholder_color; ?>;
    }
    .fl-node-<?php echo $id; ?> .gform_wrapper .gfield textarea::-webkit-input-placeholder {
        color: #<?php echo $settings->placeholder_color; ?>;
    }
    .fl-node-<?php echo $id; ?> .gform_wrapper .gfield textarea:-moz-placeholder {
        color: #<?php echo $settings->placeholder_color; ?>;
    }
    .fl-node-<?php echo $id; ?> .gform_wrapper .gfield textarea::-moz-placeholder {
        color: #<?php echo $settings->placeholder_color; ?>;
    }
    .fl-node-<?php echo $id; ?> .gform_wrapper .gfield textarea:-ms-input-placeholder {
        color: #<?php echo $settings->placeholder_color; ?>;
    }
<?php } ?>

<?php if( $settings->input_placeholder_display == 'none' ) { ?>
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield input::-webkit-input-placeholder {
    color: transparent;
    opacity: 0;
}
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield input:-moz-placeholder {
    color: transparent;
    opacity: 0;
}
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield input::-moz-placeholder {
    color: transparent;
    opacity: 0;
}
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield input:-ms-input-placeholder {
    color: transparent;
    opacity: 0;
}
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield textarea::-webkit-input-placeholder {
    color: transparent;
    opacity: 0;
}
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield textarea:-moz-placeholder {
    color: transparent;
    opacity: 0;
}
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield textarea::-moz-placeholder {
    color: transparent;
    opacity: 0;
}
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield textarea:-ms-input-placeholder {
    color: transparent;
    opacity: 0;
}
<?php } ?>


/* Button CSS */
<?php
$settings->btn_background_color = uabb_theme_button_bg_color( $settings->btn_background_color );
$settings->btn_background_hover_color = uabb_theme_button_bg_hover_color( $settings->btn_background_hover_color );
$settings->btn_text_color       = uabb_theme_button_text_color( $settings->btn_text_color );
$settings->btn_text_hover_color = uabb_theme_button_text_hover_color( $settings->btn_text_hover_color );

$settings->btn_border_width = ( isset( $settings->btn_border_width ) && $settings->btn_border_width != '' ) ? $settings->btn_border_width : '2';



// Border Size & Border Color

if ( $settings->btn_style == 'transparent' ) {
    $border_size = $settings->btn_border_width;
    $border_color = $settings->btn_background_color;
    $border_hover_color =  $settings->btn_background_hover_color ;
}

$bg_grad_start = $bg_hover_grad_start = '';
// Background Gradient
if ( $settings->btn_style == 'gradient' ) {
    if ( ! empty( $settings->btn_background_color ) ) {
        $bg_grad_start = '#'.FLBuilderColor::adjust_brightness( uabb_parse_color_to_hex( $settings->btn_background_color ), 30, 'lighten' );
    }
    if ( ! empty( $settings->btn_background_hover_color ) ) {
        $bg_hover_grad_start = '#'.FLBuilderColor::adjust_brightness( uabb_parse_color_to_hex( $settings->btn_background_hover_color ), 30, 'lighten' );
    }
}
?>

.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gform_footer {
    text-align: <?php echo $settings->btn_align; ?>;
    <?php if( $settings->typo_show_label == 'none' ) { ?>
        margin: 0;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gform_footer input[type=submit],
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_page .gform_page_footer input[type=button],
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_page .gform_page_footer input[type=submit] {

    <?php if ( $settings->btn_border_radius != '' ) { ?>
        border-radius: <?php echo $settings->btn_border_radius; ?>px;
    <?php } ?>

    <?php if ( $settings->btn_text_transform != '' ) { ?>
        text-transform: <?php echo $settings->btn_text_transform; ?>;
    <?php } ?>

    <?php if ( $settings->btn_style == 'flat' ) { ?>
        background: <?php echo uabb_theme_base_color( $settings->btn_background_color ); ?>;
        border-color: <?php echo uabb_theme_base_color( $settings->btn_background_color ); ?>;
    <?php }elseif ( $settings->btn_style == 'transparent' ) { ?>
        background-color: rgba(0, 0, 0, 0);
        border-style: solid;
        border-color: <?php echo $border_color; ?>;
        border-width: <?php echo $settings->btn_border_width; ?>px;
    <?php }elseif ( $settings->btn_style == 'gradient' ) { ?>
        background: -moz-linear-gradient(top,  <?php echo $bg_grad_start; ?> 0%, <?php echo $settings->btn_background_color; ?> 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $bg_grad_start; ?>), color-stop(100%,<?php echo $settings->btn_background_color; ?>)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  <?php echo $bg_grad_start; ?> 0%,<?php echo $settings->btn_background_color; ?> 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  <?php echo $bg_grad_start; ?> 0%,<?php echo $settings->btn_background_color; ?> 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  <?php echo $bg_grad_start; ?> 0%,<?php echo $settings->btn_background_color; ?> 100%); /* IE10+ */
        background: linear-gradient(to bottom,  <?php echo $bg_grad_start; ?> 0%,<?php echo $settings->btn_background_color; ?> 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $bg_grad_start; ?>', endColorstr='<?php echo $settings->btn_background_color; ?>',GradientType=0 ); /* IE6-9 */
    <?php }elseif ( $settings->btn_style == '3d' ) { ?>
        position: relative;
        -webkit-transition: none;
           -moz-transition: none;
                transition: none;
        background: <?php echo uabb_theme_base_color( $settings->btn_background_color ); ?>;
        <?php $shadow_color = "#" . FLBuilderColor::adjust_brightness( uabb_parse_color_to_hex( $settings->btn_background_color ), 30, 'darken' ); ?>
        box-shadow: 0 6px <?php echo $shadow_color; ?>;
    <?php } ?>

    color: <?php echo uabb_theme_text_color( $settings->btn_text_color ); ?>;
    
    
    <?php if ( $settings->btn_width == 'full' ) { ?>
        padding: <?php echo uabb_theme_button_padding( '' ); ?>;
        width:100%;
    <?php }elseif( $settings->btn_width == 'custom' ) { 
        
        $padding_top_bottom = ( $settings->btn_padding_top_bottom !== '' ) ? $settings->btn_padding_top_bottom : uabb_theme_button_vertical_padding('');
    ?>

        padding-top: <?php echo $padding_top_bottom; ?>px;
        padding-bottom: <?php echo $padding_top_bottom; ?>px;
        <?php if ( $settings->btn_custom_width != ''  ) { ?>
            width: <?php echo $settings->btn_custom_width; ?>px;
        <?php } ?>
        
        <?php if ( $settings->btn_custom_height != ''  ) { ?>
            min-height: <?php echo $settings->btn_custom_height; ?>px;
        <?php } ?>

    <?php } ?>

}

.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gform_footer input[type=submit]:hover,
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_page .gform_page_footer input[type=button]:hover,
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_page .gform_page_footer input[type=submit]:hover {
    <?php if ( $settings->btn_style == 'flat' ) { ?>
        <?php if( $settings->btn_text_hover_color != '' ) { ?>
        color: <?php echo $settings->btn_text_hover_color; ?>;
        <?php } ?>

        <?php if( $settings->btn_background_hover_color != '' ) { ?>
        background: <?php echo $settings->btn_background_hover_color; ?>;
        border-color: <?php echo $settings->btn_background_hover_color; ?>;
        <?php } ?>
    <?php }elseif ( $settings->btn_style == 'transparent' ) { ?>
        <?php if( $settings->btn_text_hover_color != '' ) { ?>
        color: <?php echo $settings->btn_text_hover_color; ?>;
        border-style: solid;
        border-width: <?php echo $settings->btn_border_width; ?>px;
        <?php }
        if( $settings->hover_attribute == 'border' ) {
        ?>
        border-color:<?php echo uabb_theme_base_color( $border_hover_color ); ?>;
        <?php
        } else {
        ?>
        background:<?php echo 'padding-box ' . uabb_theme_base_color( $border_hover_color ); ?>;
        border-color:<?php echo uabb_theme_base_color( $border_hover_color ); ?>;
        <?php
        } ?>
    <?php }elseif ( $settings->btn_style == 'gradient' ) { ?>
        <?php if( $settings->btn_text_hover_color != '' ) { ?>
        color: <?php echo $settings->btn_text_hover_color; ?>;
        <?php } ?>

        background: -moz-linear-gradient(top,  <?php echo $bg_hover_grad_start; ?> 0%, <?php echo $settings->btn_background_hover_color; ?> 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $bg_hover_grad_start; ?>), color-stop(100%,<?php echo $settings->btn_background_hover_color; ?>)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  <?php echo $bg_hover_grad_start; ?> 0%,<?php echo $settings->btn_background_hover_color; ?> 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  <?php echo $bg_hover_grad_start; ?> 0%,<?php echo $settings->btn_background_hover_color; ?> 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  <?php echo $bg_hover_grad_start; ?> 0%,<?php echo $settings->btn_background_hover_color; ?> 100%); /* IE10+ */
        background: linear-gradient(to bottom,  <?php echo $bg_hover_grad_start; ?> 0%,<?php echo $settings->btn_background_hover_color; ?> 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $bg_hover_grad_start; ?>', endColorstr='<?php echo $settings->btn_background_hover_color; ?>',GradientType=0 ); /* IE6-9 */
    <?php }elseif ( $settings->btn_style == '3d' ) {
        $shadow_color = "#" . FLBuilderColor::adjust_brightness( uabb_parse_color_to_hex( $settings->btn_background_hover_color ), 30, 'darken' );
        ?>
        <?php if( $settings->btn_text_hover_color != '' ) { ?>
        color: <?php echo $settings->btn_text_hover_color; ?>;
        <?php } ?>
        top: 2px;
        box-shadow: 0 4px <?php echo uabb_theme_base_color( $shadow_color ); ?>;
        background: <?php echo uabb_theme_base_color( $settings->btn_background_hover_color ); ?>;
    <?php } ?>
}


.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gform_footer input[type=submit]:active,
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_page .gform_page_footer input[type=button]:active,
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_page .gform_page_footer input[type=submit]:active {
    <?php if ( $settings->btn_style == '3d' ) { ?>
        top: 6px;
        box-shadow: 0 0px <?php echo uabb_theme_base_color( $shadow_color ); ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=tel],
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=email],
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=text],
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=url],
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=number],
.fl-node-<?php echo $id; ?> .uabb-gf-style input[type=date],
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield select,
.fl-node-<?php echo $id; ?> .uabb-gf-style textarea,
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield .ginput_container_checkbox,
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield .ginput_container_radio,
.gform_wrapper .ginput_container_select .chosen-container-single {
    <?php if ( $settings->input_top_margin != '' ) { ?>
        margin-top:<?php echo $settings->input_top_margin; ?>px !important;
    <?php } ?>
    <?php if ( $settings->input_bottom_margin != '' ) { ?>
        margin-bottom:<?php echo $settings->input_bottom_margin; ?>px !important;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .uabb-gf-style .ginput_container_textarea textarea {
    <?php if ( $settings->textarea_height != '' ) { ?>
    height: <?php echo $settings->textarea_height; ?>px;
    <?php } ?>
}

/* Typography CSS */
.fl-node-<?php echo $id; ?> .uabb-gf-style .uabb-gf-form-title {
	display: <?php echo ($settings->typo_show_title == 'none') ? 'none' : 'block'; ?>;
	<?php if( $settings->typo_show_title == 'block' ) { ?>
		<?php if( $settings->form_title_font_family['family'] != "Default") : ?>
			<?php UABB_Helper::uabb_font_css( $settings->form_title_font_family ); ?>
		<?php endif; ?>

        <?php if( $converted === 'yes' || isset( $settings->form_title_font_size_unit ) && $settings->form_title_font_size_unit != '' ) { ?>
            font-size: <?php echo $settings->form_title_font_size_unit; ?>px;   
        <?php } else if( isset( $settings->form_title_font_size_unit ) && $settings->form_title_font_size_unit == '' && isset( $settings->form_title_font_size['desktop'] ) && $settings->form_title_font_size['desktop'] != '' ) { ?>
            font-size: <?php echo $settings->form_title_font_size['desktop']; ?>px;
        <?php } ?>
	    
	    <?php if( isset( $settings->form_title_font_size['desktop'] ) && $settings->form_title_font_size['desktop'] == '' && isset( $settings->form_title_line_height['desktop'] ) && $settings->form_title_line_height['desktop'] != '' && $settings->form_title_line_height_unit == '' ) { ?>
		    line-height: <?php echo $settings->form_title_line_height['desktop']; ?>px;
		<?php } ?>

        <?php if( $converted === 'yes' || isset( $settings->form_title_line_height_unit ) && $settings->form_title_line_height_unit != '' ) { ?>
            line-height: <?php echo $settings->form_title_line_height_unit; ?>em;  
        <?php }  else if( isset( $settings->form_title_line_height_unit ) && $settings->form_title_line_height_unit == '' && isset( $settings->form_title_line_height['desktop'] ) && $settings->form_title_line_height['desktop'] != '' ) { ?>
            line-height: <?php echo $settings->form_title_line_height['desktop']; ?>px;
        <?php } ?>   
		
		<?php if( $settings->form_title_color != '' ) : ?>
		color: <?php echo $settings->form_title_color; ?>;
		<?php endif; ?>

        text-align: <?php echo $settings->form_text_align; ?>;
        
        margin: 0 0 <?php echo ( $settings->form_title_bottom_margin != '' ) ? $settings->form_title_bottom_margin : '0'; ?>px;

        <?php if( $settings->form_title_transform != '' ) ?>
           text-transform: <?php echo $settings->form_title_transform; ?>;

        <?php if( $settings->form_title_letter_spacing != '' ) ?>
           letter-spacing: <?php echo $settings->form_title_letter_spacing; ?>px;

    <?php } ?>
}

.fl-node-<?php echo $id; ?> .uabb-gf-style .uabb-gf-form-desc {

	display: <?php echo ($settings->typo_show_desc == 'none') ? 'none' : 'block'; ?>;
	<?php if( $settings->typo_show_desc == 'block' ) { ?>
		<?php if( $settings->form_desc_font_family['family'] != "Default") : ?>
			<?php UABB_Helper::uabb_font_css( $settings->form_desc_font_family ); ?>
		<?php endif; ?>

        <?php if( $converted === 'yes' || isset( $settings->form_desc_font_size_unit ) && $settings->form_desc_font_size_unit != '' ) { ?>
            font-size: <?php echo $settings->form_desc_font_size_unit; ?>px;    
        <?php } else if( isset( $settings->form_desc_font_size_unit ) && $settings->form_desc_font_size_unit == '' && isset( $settings->form_desc_font_size['desktop'] ) && $settings->form_desc_font_size['desktop'] != '' ) { ?>
            font-size: <?php echo $settings->form_desc_font_size['desktop']; ?>px;
        <?php } ?> 
	    
	    <?php if( isset( $settings->form_desc_font_size['desktop'] ) && $settings->form_desc_font_size['desktop'] == '' && isset( $settings->form_desc_line_height['desktop'] ) && $settings->form_desc_line_height['desktop'] != '' && $settings->form_desc_line_height_unit == '' ) { ?>
		    line-height: <?php echo $settings->form_desc_line_height['desktop']; ?>px;
		<?php } ?>

        <?php if( $converted === 'yes' || isset( $settings->form_desc_line_height_unit ) && $settings->form_desc_line_height_unit != '' ) { ?>
            line-height: <?php echo $settings->form_desc_line_height_unit; ?>em;  
        <?php }  else if( isset( $settings->form_desc_line_height_unit ) && $settings->form_desc_line_height_unit == '' && isset( $settings->form_desc_line_height['desktop'] ) && $settings->form_desc_line_height['desktop'] != '' ) { ?>
            line-height: <?php echo $settings->form_desc_line_height['desktop']; ?>px;
        <?php } ?> 
		
		<?php if( $settings->form_desc_color != '' ) : ?>
		  color: <?php echo $settings->form_desc_color; ?>;
		<?php endif; ?>

        text-align: <?php echo $settings->form_text_align; ?>;

        margin: 0 0 <?php echo ( $settings->form_desc_bottom_margin != '' ) ? $settings->form_desc_bottom_margin : '20'; ?>px;

        <?php if( $settings->form_desc_transform != '' ) ?>
           text-transform: <?php echo $settings->form_desc_transform; ?>;

        <?php if( $settings->form_desc_letter_spacing != '' ) ?>
           letter-spacing: <?php echo $settings->form_desc_letter_spacing; ?>px;

    <?php } ?>

}

.fl-node-<?php echo $id; ?> .uabb-gf-style input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
.fl-node-<?php echo $id; ?> .uabb-gf-style select,
.gform_wrapper .ginput_container_select .chosen-container-single .chosen-single {
    <?php if( $settings->input_field_height == '' ) { ?>
        height: auto;
    <?php } else { ?>
        height: <?php echo $settings->input_field_height; ?>px
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .gfield input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield input:focus,
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield select,
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield textarea,
.gform_wrapper .ginput_container_select .chosen-container-single .chosen-single {

    <?php if( $settings->font_family['family'] != 'Default' ) { ?>
    <?php FLBuilderFonts::font_css( $settings->font_family ); ?>
    <?php } ?>

    <?php if( $converted === 'yes' || isset( $settings->font_size_unit ) && $settings->font_size_unit != '' ) { ?>
        font-size: <?php echo $settings->font_size_unit; ?>px;   
    <?php } else if( isset( $settings->font_size_unit ) && $settings->font_size_unit == '' && isset( $settings->font_size['desktop'] ) && $settings->font_size['desktop'] != '' ) { ?>
        font-size: <?php echo $settings->font_size['desktop']; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gform_footer input[type=submit],
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_page .gform_page_footer input[type=button],
.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_page .gform_page_footer input[type=submit] {
	margin-right : 0;
	<?php $uabb_theme_btn_family = apply_filters( 'uabb/theme/button_font_family', '' ); ?>
	
	<?php if ( uabb_theme_button_letter_spacing('') != '' ) { ?>
	letter-spacing: <?php echo uabb_theme_button_letter_spacing(''); ?>;
	<?php } ?>

	<?php if ( uabb_theme_button_text_transform('') != '' ) { ?>
	text-transform: <?php echo uabb_theme_button_text_transform(''); ?>;
	<?php } ?>

	<?php if( $settings->btn_font_family['family'] != "Default") : ?>
		<?php UABB_Helper::uabb_font_css( $settings->btn_font_family ); ?>
	<?php else : ?>
		<?php if( isset( $uabb_theme_btn_family['family'] ) ) { ?>
		font-family: <?php echo $uabb_theme_btn_family['family']; ?>;
		<?php } ?> 
		
		<?php if ( isset( $uabb_theme_btn_family['weight'] ) ) { ?>
		font-weight: <?php echo $uabb_theme_btn_family['weight']; ?>;
		<?php } ?>
	<?php endif; ?>

    <?php if( $converted === 'yes' || isset( $settings->btn_font_size_unit ) && $settings->btn_font_size_unit != '' ) { ?>
        font-size: <?php echo $settings->btn_font_size_unit; ?>px; 
    <?php } else { ?>
            <?php if ( uabb_theme_button_line_height('') != '' ) { ?>
                font-size: <?php echo uabb_theme_button_font_size(''); ?>;
            <?php } ?>
    <?php } ?>

    <?php if( $converted !== 'yes' && isset( $settings->btn_font_size_unit ) && $settings->btn_font_size_unit == '' && isset( $settings->btn_font_size['desktop'] ) && $settings->btn_font_size['desktop'] != '' ) { ?>
        font-size: <?php echo $settings->btn_font_size['desktop']; ?>px;
    <?php } ?>
    
    <?php if( isset( $settings->btn_font_size['desktop'] ) && $settings->btn_font_size['desktop'] == '' && isset( $settings->btn_line_height['desktop'] ) && $settings->btn_line_height['desktop'] != '' && $settings->btn_line_height_unit == '' ) { ?>
		    line-height: <?php echo $settings->btn_line_height['desktop']; ?>px;
	<?php } ?>

    <?php if( $converted === 'yes' || isset( $settings->btn_line_height_unit ) && $settings->btn_line_height_unit != '' ) { ?>
    line-height: <?php echo $settings->btn_line_height_unit; ?>em;
    <?php } else { ?>
            <?php if ( uabb_theme_button_line_height('') != '' ) { ?>
                line-height: <?php echo uabb_theme_button_line_height(''); ?>;
            <?php } ?>
    <?php } ?>

    <?php if( $converted !== 'yes' && isset( $settings->btn_line_height_unit ) && $settings->btn_line_height_unit == '' && isset( $settings->btn_line_height['desktop'] ) && $settings->btn_line_height['desktop'] != '' ) { ?>
        line-height: <?php echo $settings->btn_line_height['desktop']; ?>px;
    <?php } ?>

    <?php if($settings->btn_text_transform!= "")?>
       text-transform: <?php echo $settings->btn_text_transform; ?>;

    <?php if($settings->btn_letter_spacing!= "")?>
	   letter-spacing: <?php echo $settings->btn_letter_spacing; ?>px;
}

.fl-node-<?php echo $id; ?> .uabb-gf-style form .gform_body .gfield_label {

    display: <?php echo ($settings->typo_show_label == 'none') ? 'none' : 'block'; ?>;
    <?php if( $settings->typo_show_label == 'block' ) { ?>

		<?php if( $settings->label_font_family['family'] != "Default") : ?>
			<?php UABB_Helper::uabb_font_css( $settings->label_font_family ); ?>
		<?php endif; ?>

        <?php if( $converted === 'yes' || isset( $settings->label_font_size_unit ) && $settings->label_font_size_unit != '' ) { ?>
            font-size: <?php echo $settings->label_font_size_unit; ?>px;     
        <?php } else if( isset( $settings->label_font_size_unit ) && $settings->label_font_size_unit == '' && isset( $settings->label_font_size['desktop'] ) && $settings->label_font_size['desktop'] != '' ) { ?>
            font-size: <?php echo $settings->label_font_size['desktop']; ?>px;
        <?php } ?>
	    
	    <?php if( isset( $settings->label_font_size['desktop'] ) && $settings->label_font_size['desktop'] == '' && isset( $settings->label_line_height['desktop'] ) && $settings->label_line_height['desktop'] != '' && $settings->label_line_height_unit == '' ) { ?>
		    line-height: <?php echo $settings->label_line_height['desktop']; ?>px;
		<?php } ?>

        <?php if( $converted === 'yes' || isset( $settings->label_line_height_unit ) && $settings->label_line_height_unit != '' ) { ?>
            line-height: <?php echo $settings->label_line_height_unit; ?>em;  
        <?php }  else if( isset( $settings->label_line_height_unit ) && $settings->label_line_height_unit == '' && isset( $settings->label_line_height['desktop'] ) && $settings->label_line_height['desktop'] != '' ) { ?>
            line-height: <?php echo $settings->label_line_height['desktop']; ?>px;
        <?php } ?>
        
        <?php if( $settings->label_transform != '' ) ?>
           text-transform: <?php echo $settings->label_transform; ?>;

        <?php if( $settings->label_letter_spacing != '' ) ?>
           letter-spacing: <?php echo $settings->label_letter_spacing; ?>px;

        <?php if( $settings->label_color != '' ) : ?>
        color: <?php echo $settings->label_color; ?>;
        <?php endif; ?>

        text-align: <?php echo $settings->input_text_align; ?>;
    <?php } ?>
}

<?php if( $settings->typo_show_label == 'none' ) { ?>
    .fl-node-<?php echo $id; ?> .gform_wrapper .gfield .gfield_description {
        margin-bottom: 20px;
    }
    .fl-node-<?php echo $id; ?> .gform_wrapper .gfield .ginput_container span label {
        display: <?php echo $settings->typo_show_label; ?>;
    }
<?php } ?>

.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .validation_message {
    color: <?php echo $settings->input_msg_color; ?>;
    font-size: <?php echo $settings->input_msg_font_size; ?>px;

    <?php if( $settings->input_error_transform != '' ) ?>
       text-transform: <?php echo $settings->input_error_transform; ?>;

    <?php if( $settings->input_error_letter_spacing != '' ) ?>
       letter-spacing: <?php echo $settings->input_error_letter_spacing; ?>px;
}

.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper div.validation_error {
    color: <?php echo $settings->validation_msg_color; ?>;
    line-height: 1.5em;
    font-size: <?php echo $settings->validation_msg_font_size; ?>px;

    <?php if( $settings->validate_transform != '' ) ?>
       text-transform: <?php echo $settings->validate_transform; ?>;

    <?php if( $settings->validate_letter_spacing != '' ) ?>
       letter-spacing: <?php echo $settings->validate_letter_spacing; ?>px;
	
	background: <?php echo $settings->validation_bg_color; ?>;
	<?php if ( $settings->validation_border_type != ''  ) { ?>
	<?php $settings->validation_border_width = $settings->validation_border_width != '' ? $settings->validation_border_width : '2'; ?>
		border: <?php echo $settings->validation_border_type.' '.$settings->validation_border_width.'px '.$settings->validation_border_color.';'; ?>
	<?php }else{ ?>
		border: none;
	<?php } ?>
	
	border-radius: <?php echo $settings->validation_border_radius; ?>px;

    <?php 
    if( $converted === 'yes' || isset($settings->validation_spacing_dimension_top) && isset( $settings->validation_spacing_dimension_bottom )  && isset( $settings->validation_spacing_dimension_left ) && isset( $settings->validation_spacing_dimension_right ) ) {
        if(isset($settings->validation_spacing_dimension_top) ){
            echo ( $settings->validation_spacing_dimension_top != '' ) ? 'padding-top:'.$settings->validation_spacing_dimension_top.'px;' : 'padding-top: 10px;'; 
        }
        if(isset($settings->validation_spacing_dimension_bottom) ){
            echo ( $settings->validation_spacing_dimension_bottom != '' ) ? 'padding-bottom:'.$settings->validation_spacing_dimension_bottom.'px;' : 'padding-bottom: 10px;';
        }
        if(isset($settings->validation_spacing_dimension_left) ){
            echo ( $settings->validation_spacing_dimension_left != '' ) ? 'padding-left:'.$settings->validation_spacing_dimension_left.'px;' : 'padding-left: 10px;';
        }
        if(isset($settings->validation_spacing_dimension_right) ){
            echo ( $settings->validation_spacing_dimension_right != '' ) ? 'padding-right:'.$settings->validation_spacing_dimension_right.'px;' : 'padding-right: 10px;';
        } 
    }
    else if( isset( $settings->validation_spacing ) && $settings->validation_spacing != '' && isset( $settings->validation_spacing_dimension_top ) && $settings->validation_spacing_dimension_top == '' && isset( $settings->validation_spacing_dimension_bottom ) && $settings->validation_spacing_dimension_bottom == ''  && isset( $settings->validation_spacing_dimension_left ) && $settings->validation_spacing_dimension_left == ''  && isset( $settings->validation_spacing_dimension_right ) && $settings->validation_spacing_dimension_right == '' ) {
        echo $settings->validation_spacing; ?>;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .gform_wrapper .gfield.gfield_error .gfield_label {
    <?php if( $settings->input_error_label_color && $settings->input_error_display == 'yes' ) { ?>
    color: #<?php echo $settings->input_error_label_color; ?>;
    <?php } ?>
    margin-left: 0;
}

.fl-node-<?php echo $id; ?> .gform_wrapper .validation_error,
.fl-node-<?php echo $id; ?> .gform_wrapper li.gfield.gfield_error,
.fl-node-<?php echo $id; ?> .gform_wrapper li.gfield.gfield_error.gfield_contains_required.gfield_creditcard_warning {
    border-top: <?php echo $settings->validation_border_type.' '.$settings->validation_border_width.'px '.$settings->validation_border_color.';'; ?>
    border-bottom: <?php echo $settings->validation_border_type.' '.$settings->validation_border_width.'px '.$settings->validation_border_color.';'; ?>
    <?php if ( ! isset( $settings->validation_border_color ) || empty( $settings->validation_border_color ) ) { ?>
        border: none;
        padding-top: 0;
        padding-bottom: 0;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .gform_wrapper .gfield.gfield_error {
    <?php if( $settings->input_error_back_color && $settings->input_error_display == 'yes' ) { ?>
        background-color: <?php echo '#' . $settings->input_error_back_color ?>;
        Width: 100%;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> .gform_wrapper .gfield_error input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield_error .ginput_container select,
.fl-node-<?php echo $id; ?> .gform_wrapper .gfield_error .ginput_container textarea,
.gform_wrapper .ginput_container_select .chosen-container-single .chosen-single { ?>
    <?php if( $settings->input_error_border_color && $settings->input_error_display == 'yes' ) { ?>
        border-color: <?php echo '#' . $settings->input_error_border_color; ?>;
    <?php } ?>
    <?php if( $settings->input_error_border_width >= 0 && $settings->input_error_display == 'yes' ) { ?>
        border-width: <?php echo $settings->input_error_border_width; ?>px;
    <?php } ?>
}

.fl-node-<?php echo $id; ?> #gform_confirmation_message_<?php echo $settings->form_id ?> {
    font-family: inherit;
    margin-top: 10px;
    <?php if( $settings->input_success_msg_color ) { ?>
        color: <?php echo '#' . $settings->input_success_msg_color ?>;
    <?php } ?>
    <?php if( $settings->input_success_msg_font_size != '' ) { ?>
        font-size: <?php echo $settings->input_success_msg_font_size ?>px;
    <?php } ?>
    <?php if( $settings->input_success_msg_transform != '' ) ?>
       text-transform: <?php echo $settings->input_success_msg_transform; ?>;

    <?php if( $settings->input_success_msg_letter_spacing != '' ) ?>
       letter-spacing: <?php echo $settings->input_success_msg_letter_spacing; ?>px;
}

/* Typography responsive css */
<?php if($global_settings->responsive_enabled) { // Global Setting If started ?>
    @media ( max-width: <?php echo $global_settings->medium_breakpoint .'px'; ?> ) {
        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield_radio li label, 
        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield_checkbox li label {
            <?php if( $settings->radio_check_custom_option == 'true' ) {?>
                <?php if( $settings->radio_checkbox_font_family['family'] != 'Default' ) { ?>
                    <?php FLBuilderFonts::font_css( $settings->radio_checkbox_font_family ); ?>
                <?php } ?>

                <?php if( $converted === 'yes' || isset( $settings->radio_checkbox_font_size_unit_medium ) && $settings->radio_checkbox_font_size_unit_medium != '' ){ ?>
                    font-size: <?php echo $settings->radio_checkbox_font_size_unit_medium; ?>px;
                <?php } else if(  isset( $settings->radio_checkbox_font_size_unit_medium ) && $settings->radio_checkbox_font_size_unit_medium == '' && isset( $settings->radio_checkbox_font_size['medium'] ) && $settings->radio_checkbox_font_size['medium'] != '' ) {?>
                    font-size: <?php echo $settings->radio_checkbox_font_size['medium']; ?>px;
                <?php } ?> 
			
				<?php if( $settings->radio_checkbox_color ) { ?>
			    	color: #<?php echo $settings->radio_checkbox_color; ?>;
			    <?php } ?>
			<?php } else if( $settings->radio_check_custom_option == 'false' ) { ?>		
				<?php if( $settings->label_font_family['family'] != "Default") : ?>
					<?php UABB_Helper::uabb_font_css( $settings->label_font_family ); ?>
				<?php endif; ?>

				<?php if( $settings->label_color != '' ) : ?>
					color: <?php echo $settings->label_color; ?>;
				<?php endif; ?>
			<?php } ?>
		}
		.fl-node-<?php echo $id; ?> .uabb-gf-style .uabb-gf-form-title {

            <?php if( $converted === 'yes' || isset( $settings->form_title_font_size_unit_medium ) && $settings->form_title_font_size_unit_medium != '' ){ ?>
                font-size: <?php echo $settings->form_title_font_size_unit_medium; ?>px; 
            <?php } else if(  isset( $settings->form_title_font_size_unit_medium ) && $settings->form_title_font_size_unit_medium == '' && isset( $settings->form_title_font_size['medium'] ) && $settings->form_title_font_size['medium'] != '' ) {?>
                font-size: <?php echo $settings->form_title_font_size['medium']; ?>px;
            <?php } ?> 
		    
		    <?php if( isset( $settings->form_title_font_size['medium'] ) && $settings->form_title_font_size['medium'] == '' && isset( $settings->form_title_line_height['medium'] ) && $settings->form_title_line_height['medium'] != '' && $settings->form_title_line_height_unit == '' && $settings->form_title_line_height_unit_medium == '' ) { ?>
			    line-height: <?php echo $settings->form_title_line_height['medium']; ?>px;
			<?php } ?>

            <?php if( $converted === 'yes' || isset( $settings->form_title_line_height_unit_medium ) && $settings->form_title_line_height_unit_medium != '' ){ ?>
                line-height: <?php echo $settings->form_title_line_height_unit_medium; ?>em;   
            <?php } else if( isset( $settings->form_title_line_height_unit_medium )&& $settings->form_title_line_height_unit_medium == '' && isset( $settings->form_title_line_height['medium'] ) && $settings->form_title_line_height['medium'] != '' ) {?>
                line-height: <?php echo $settings->form_title_line_height['medium']; ?>px;
            <?php } ?>
        }

        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield .gfield_radio li label, 
        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield .gfield_checkbox li label {
            <?php if( isset($settings->radio_checkbox_font_size["medium"]) && $settings->radio_checkbox_font_size["medium"] != '' && $settings->radio_check_custom_option == 'true' ) : ?>
                font-size: <?php echo $settings->radio_checkbox_font_size['medium']; ?>px;
            <?php endif; ?>
        }

		.fl-node-<?php echo $id; ?> .uabb-gf-style .uabb-gf-form-desc {

            <?php if( $converted === 'yes' || isset( $settings->form_desc_font_size_unit_medium ) && $settings->form_desc_font_size_unit_medium != '' ){ ?>
                font-size: <?php echo $settings->form_desc_font_size_unit_medium; ?>px;
            <?php } else if(  isset( $settings->form_desc_font_size_unit_medium ) && $settings->form_desc_font_size_unit_medium == '' && isset( $settings->form_desc_font_size['medium'] ) && $settings->form_desc_font_size['medium'] != '' ) {?>
                font-size: <?php echo $settings->form_desc_font_size['medium']; ?>px;
            <?php } ?> 
		    
		    <?php if( isset( $settings->form_desc_font_size['medium'] ) && $settings->form_desc_font_size['medium'] == '' && isset( $settings->form_desc_line_height['medium'] ) && $settings->form_desc_line_height['medium'] != '' && $settings->form_desc_line_height_unit == '' && $settings->form_desc_line_height_unit_medium == '' ) { ?>
				    line-height: <?php echo $settings->form_desc_line_height['medium']; ?>px;
			<?php } ?>

            <?php if( $converted === 'yes' || isset( $settings->form_desc_line_height_unit_medium ) && $settings->form_desc_line_height_unit_medium != '' ){ ?>
                line-height: <?php echo $settings->form_desc_line_height_unit_medium; ?>em;   
            <?php } else if( isset( $settings->form_desc_line_height_unit_medium )&& $settings->form_desc_line_height_unit_medium == '' && isset( $settings->form_desc_line_height['medium'] ) && $settings->form_desc_line_height['medium'] != '' ) {?>
                line-height: <?php echo $settings->form_desc_line_height['medium']; ?>px;
            <?php } ?>
		}

		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=tel],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=email],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=text],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=url],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=number],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=date],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> select,
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> textarea,
		.gform_wrapper .ginput_container_select .chosen-container-single .chosen-single {
			
			<?php if( isset( $settings->font_size_unit_medium ) && $settings->font_size_unit_medium != '' ) : ?>
				font-size: <?php echo $settings->font_size_unit_medium; ?>px;
			<?php endif; ?>
		}

		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gform_footer input[type=submit],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_page .gform_page_footer input[type=button],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_page .gform_page_footer input[type=submit] {

            <?php if( $converted === 'yes' || isset( $settings->btn_font_size_unit_medium ) && $settings->btn_font_size_unit_medium != '' ){ ?>
                font-size: <?php echo $settings->btn_font_size_unit_medium; ?>px;
            <?php } else if(  isset( $settings->btn_font_size_unit_medium ) && $settings->btn_font_size_unit_medium == '' && isset( $settings->btn_font_size['medium'] ) && $settings->btn_font_size['medium'] != '' ) {?>
                font-size: <?php echo $settings->btn_font_size['medium']; ?>px;
            <?php } ?>

	        <?php if( isset( $settings->btn_font_size['medium'] ) && $settings->btn_font_size['medium'] == '' && isset( $settings->btn_line_height['medium'] ) && $settings->btn_line_height['medium'] != '' && $settings->btn_line_height_unit == '' && $settings->btn_line_height_unit_medium == '' ) { ?>
				    line-height: <?php echo $settings->btn_line_height['medium']; ?>px;
			<?php } ?>

            <?php if( $converted === 'yes' || isset( $settings->btn_line_height_unit_medium ) && $settings->btn_line_height_unit_medium != '' ){ ?>
                line-height: <?php echo $settings->btn_line_height_unit_medium; ?>em;   
            <?php } else if( isset( $settings->btn_line_height_unit_medium )&& $settings->btn_line_height_unit_medium == '' && isset( $settings->btn_line_height['medium'] ) && $settings->btn_line_height['medium'] != '' ) {?>
                line-height: <?php echo $settings->btn_line_height['medium']; ?>px;
            <?php } ?>

        }

		.fl-node-<?php echo $id; ?> .uabb-gf-style form:not(input) {

            <?php if( $converted === 'yes' || isset( $settings->label_font_size_unit_medium ) && $settings->label_font_size_unit_medium != '' ){ ?>
                font-size: <?php echo $settings->label_font_size_unit_medium; ?>px;
            <?php } else if(  isset( $settings->label_font_size_unit_medium ) && $settings->label_font_size_unit_medium == '' && isset( $settings->label_font_size['medium'] ) && $settings->label_font_size['medium'] != '' ) {?>
                font-size: <?php echo $settings->label_font_size['medium']; ?>px;
            <?php } ?> 
		    
		    <?php if( isset( $settings->label_font_size['medium'] ) && $settings->label_font_size['medium'] == '' && isset( $settings->label_line_height['medium'] ) && $settings->label_line_height['medium'] != '' && $settings->label_line_height_unit == '' && $settings->label_line_height_unit_medium == '' ) { ?>
				    line-height: <?php echo $settings->label_line_height['medium']; ?>px;
			<?php } ?>

            <?php if( $converted === 'yes' || isset( $settings->label_line_height_unit_medium ) && $settings->label_line_height_unit_medium != '' ){ ?>
                line-height: <?php echo $settings->label_line_height_unit_medium; ?>em;   
            <?php } else if( isset( $settings->label_line_height_unit_medium )&& $settings->label_line_height_unit_medium == '' && isset( $settings->label_line_height['medium'] ) && $settings->label_line_height['medium'] != '' ) {?>
                line-height: <?php echo $settings->label_line_height['medium']; ?>px;
            <?php } ?>
            
        }

        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper div.validation_error {

            <?php 
                if(isset($settings->validation_spacing_dimension_top_medium) ){
                    echo ( $settings->validation_spacing_dimension_top_medium != '' ) ? 'padding-top:'.$settings->validation_spacing_dimension_top_medium.'px;' : ''; 
                }
                if(isset($settings->validation_spacing_dimension_bottom_medium) ){
                    echo ( $settings->validation_spacing_dimension_bottom_medium != '' ) ? 'padding-bottom:'.$settings->validation_spacing_dimension_bottom_medium.'px;' : 'p';
                }
                if(isset($settings->validation_spacing_dimension_left_medium) ){
                    echo ( $settings->validation_spacing_dimension_left_medium != '' ) ? 'padding-left:'.$settings->validation_spacing_dimension_left_medium.'px;' : '';
                }
                if(isset($settings->validation_spacing_dimension_right_medium) ){
                    echo ( $settings->validation_spacing_dimension_right_medium != '' ) ? 'padding-right:'.$settings->validation_spacing_dimension_right_medium.'px;' : '';
                } 
            ?>
        }

        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=tel],
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=email],
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=text],
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=url],
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=number],
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=date],
        .fl-node-<?php echo $id; ?> .uabb-gf-style select,
        .fl-node-<?php echo $id; ?> .uabb-gf-style textarea,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=tel]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=email]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=text]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=url]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=number]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=date]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style select:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style textarea:focus,
        .gform_wrapper .ginput_container_select .chosen-container-single .chosen-single {
            <?php 
                if(isset($settings->input_border_width_dimension_top_medium) ){
                    echo ( $settings->input_border_width_dimension_top_medium != '' ) ? 'padding-top:'.$settings->input_border_width_dimension_top_medium.'px;' : ''; 
                }
                if(isset($settings->input_border_width_dimension_bottom_medium) ){
                    echo ( $settings->input_border_width_dimension_bottom_medium != '' ) ? 'padding-bottom:'.$settings->input_border_width_dimension_bottom_medium.'px;' : '';
                }
                if(isset($settings->input_border_width_dimension_left_medium) ){
                    echo ( $settings->input_border_width_dimension_left_medium != '' ) ? 'padding-left:'.$settings->input_border_width_dimension_left_medium.'px;' : '';
                }
                if(isset($settings->input_border_width_dimension_right_medium) ){
                    echo ( $settings->input_border_width_dimension_right_medium != '' ) ? 'padding-right:'.$settings->input_border_width_dimension_right_medium.'px;' : '';
                } 
            ?>
        }


        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper form .gform_body input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
        .fl-node-<?php echo $id; ?> .gform_wrapper textarea,
        .fl-node-<?php echo $id; ?> .gform_wrapper .gfield .ginput_container select,
        .gform_wrapper .ginput_container_select .chosen-container-single .chosen-single {
            <?php 
                if(isset($settings->input_padding_dimension_top_medium) ){
                    echo ( $settings->input_padding_dimension_top_medium != '' ) ? 'padding-top:'.$settings->input_padding_dimension_top_medium.'px;' : ''; 
                }
                if(isset($settings->input_padding_dimension_bottom_medium) ){
                    echo ( $settings->input_padding_dimension_bottom_medium != '' ) ? 'padding-bottom:'.$settings->input_padding_dimension_bottom_medium.'px;' : '';
                }
                if(isset($settings->input_padding_dimension_left_medium) ){
                    echo ( $settings->input_padding_dimension_left_medium != '' ) ? 'padding-left:'.$settings->input_padding_dimension_left_medium.'px;' : '';
                }
                if(isset($settings->input_padding_dimension_right_medium) ){
                    echo ( $settings->input_padding_dimension_right_medium != '' ) ? 'padding-right:'.$settings->input_padding_dimension_right_medium.'px;' : '';
                } 
            ?>
        }

        .fl-node-<?php echo $id; ?> .uabb-gf-style {
            <?php 
                if(isset($settings->form_spacing_dimension_top_medium) ){
                    echo ( $settings->form_spacing_dimension_top_medium != '' ) ? 'padding-top:'.$settings->form_spacing_dimension_top_medium.'px;' : ''; 
                }
                if(isset($settings->form_spacing_dimension_bottom_medium) ){
                    echo ( $settings->form_spacing_dimension_bottom_medium != '' ) ? 'padding-bottom:'.$settings->form_spacing_dimension_bottom_medium.'px;' : '';
                }
                if(isset($settings->form_spacing_dimension_left_medium) ){
                    echo ( $settings->form_spacing_dimension_left_medium != '' ) ? 'padding-left:'.$settings->form_spacing_dimension_left_medium.'px;' : '';
                }
                if(isset($settings->form_spacing_dimension_right_medium) ){
                    echo ( $settings->form_spacing_dimension_right_medium != '' ) ? 'padding-right:'.$settings->form_spacing_dimension_right_medium.'px;' : ';';
                } 
            ?>
        }
    }
    @media ( max-width: <?php echo $global_settings->responsive_breakpoint .'px'; ?> ) {
        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield_radio li label, 
        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield_checkbox li label {
            <?php if( $settings->radio_check_custom_option == 'true' ) {?>
                <?php if( $settings->radio_checkbox_font_family['family'] != 'Default' ) { ?>
                    <?php FLBuilderFonts::font_css( $settings->radio_checkbox_font_family ); ?>
                <?php } ?>

                <?php if( $converted === 'yes' || isset( $settings->radio_checkbox_font_size_unit_responsive ) && $settings->radio_checkbox_font_size_unit_responsive != '' ) { ?>
                    font-size: <?php echo $settings->radio_checkbox_font_size_unit_responsive; ?>px;      
                <?php } else if(isset( $settings->radio_checkbox_font_size_unit_responsive ) && $settings->radio_checkbox_font_size_unit_responsive == '' && isset( $settings->radio_checkbox_font_size['small'] ) && $settings->radio_checkbox_font_size['small'] != '') { ?>
                    font-size: <?php echo $settings->radio_checkbox_font_size['small']; ?>px;
                <?php } ?>
				<?php if( $settings->radio_checkbox_color ) { ?>
			    	color: #<?php echo $settings->radio_checkbox_color; ?>;
			    <?php } ?>
			<?php } else if( $settings->radio_check_custom_option == 'false' ) { ?>		
				<?php if( $settings->label_font_family['family'] != "Default") : ?>
					<?php UABB_Helper::uabb_font_css( $settings->label_font_family ); ?>
				<?php endif; ?>

				<?php if( $settings->label_color != '' ) : ?>
					color: <?php echo $settings->label_color; ?>;
				<?php endif; ?>
			<?php } ?>
		}

		.fl-node-<?php echo $id; ?> .uabb-gf-style .uabb-gf-form-title {

            <?php if( $converted === 'yes' || isset( $settings->form_title_font_size_unit_responsive ) && $settings->form_title_font_size_unit_responsive != '' ) { ?>
                font-size: <?php echo $settings->form_title_font_size_unit_responsive; ?>px;   
            <?php } else if(isset( $settings->form_title_font_size_unit_responsive ) && $settings->form_title_font_size_unit_responsive == '' && isset( $settings->form_title_font_size['small'] ) && $settings->form_title_font_size['small'] != '') { ?>
                font-size: <?php echo $settings->form_title_font_size['small']; ?>px;
            <?php } ?>
		    
		    <?php if( isset( $settings->form_title_font_size['small'] ) && $settings->form_title_font_size['small'] == '' && isset( $settings->form_title_line_height['small'] ) && $settings->form_title_line_height['small'] != '' && $settings->form_title_line_height_unit_responsive == '' && $settings->form_title_line_height_unit_medium == '' && $settings->form_title_line_height_unit == '' ) { ?>
				    line-height: <?php echo $settings->form_title_line_height['small']; ?>px;
			<?php } ?>

            <?php if( $converted === 'yes' || isset( $settings->form_title_line_height_unit_responsive ) && $settings->form_title_line_height_unit_responsive != '' ) { ?>
                line-height: <?php echo $settings->form_title_line_height_unit_responsive; ?>em;
            <?php } else if( isset( $settings->form_title_line_height_unit_responsive )&& $settings->form_title_line_height_unit_responsive == '' && isset( $settings->form_title_line_height['small'] ) && $settings->form_title_line_height['small'] != '' ) {?>
                line-height: <?php echo $settings->form_title_line_height['small']; ?>px;
            <?php } ?>
        }

        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield .gfield_radio li label, 
        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper .gfield .gfield_checkbox li label {
            <?php if( isset( $settings->radio_checkbox_font_size["small"] ) && $settings->radio_checkbox_font_size["small"] != '' && $settings->radio_check_custom_option == 'true' ) : ?>
                font-size: <?php echo $settings->radio_checkbox_font_size['small']; ?>px;
            <?php endif; ?>
        }

		.fl-node-<?php echo $id; ?> .uabb-gf-style .uabb-gf-form-desc {

            <?php if( $converted === 'yes' || isset( $settings->form_desc_font_size_unit_responsive ) && $settings->form_desc_font_size_unit_responsive != '' ) { ?>
                font-size: <?php echo $settings->form_desc_font_size_unit_responsive; ?>px;    
            <?php } else if(isset( $settings->form_desc_font_size_unit_responsive ) && $settings->form_desc_font_size_unit_responsive == '' && isset( $settings->form_desc_font_size['small'] ) && $settings->form_desc_font_size['small'] != '') { ?>
                font-size: <?php echo $settings->form_desc_font_size['small']; ?>px;
            <?php } ?>
		    
		    <?php if( isset( $settings->form_desc_font_size['small'] ) && $settings->form_desc_font_size['small'] == '' && isset( $settings->form_desc_line_height['small'] ) && $settings->form_desc_line_height['small'] != '' && $settings->form_desc_line_height_unit_responsive == '' && $settings->form_desc_line_height_unit_medium == '' && $settings->form_desc_line_height_unit == '' ) { ?>
			    line-height: <?php echo $settings->form_desc_line_height['small']; ?>px;
			<?php } ?>

            <?php if( $converted === 'yes' || isset( $settings->form_desc_line_height_unit_responsive ) && $settings->form_desc_line_height_unit_responsive != '' ) { ?>
                line-height: <?php echo $settings->form_desc_line_height_unit_responsive; ?>em;
            <?php } else if( isset( $settings->form_desc_line_height_unit_responsive )&& $settings->form_desc_line_height_unit_responsive == '' && isset( $settings->form_desc_line_height['small'] ) && $settings->form_desc_line_height['small'] != '' ) {?>
                line-height: <?php echo $settings->form_desc_line_height['small']; ?>px;
            <?php } ?>			
		}

		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=tel],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=email],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=text],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=url],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=number],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> input[type=date],
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> select,
		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> textarea,
		.gform_wrapper .ginput_container_select .chosen-container-single .chosen-single {

			<?php if( isset( $settings->font_size_unit_responsive ) && $settings->font_size_unit_responsive != '' ) : ?>
				font-size: <?php echo $settings->font_size_unit_responsive; ?>px;
			<?php endif; ?>
			
		}

		.fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper <?php echo '#gform_' . $settings->form_id; ?> .gform_footer input[type=submit],
		.fl-node-<?php echo $id; ?> .uabb-gf-style <?php echo '#gform_' . $settings->form_id; ?> .gform_page .gform_page_footer input[type=button],
		.fl-node-<?php echo $id; ?> .uabb-gf-style <?php echo '#gform_' . $settings->form_id; ?> .gform_page .gform_page_footer input[type=submit] {

            <?php if( $converted === 'yes' || isset( $settings->btn_font_size_unit_responsive ) && $settings->btn_font_size_unit_responsive != '' ) { ?>
                font-size: <?php echo $settings->btn_font_size_unit_responsive; ?>px;     
            <?php } else if(isset( $settings->btn_font_size_unit_responsive ) && $settings->btn_font_size_unit_responsive == '' && isset( $settings->btn_font_size['small'] ) && $settings->btn_font_size['small'] != '') { ?>
                font-size: <?php echo $settings->btn_font_size['small']; ?>px;
            <?php } ?>
		    
		    <?php if( isset( $settings->btn_font_size['small'] ) && $settings->btn_font_size['small'] == '' && isset( $settings->btn_line_height['small'] ) && $settings->btn_line_height['small'] != '' && $settings->btn_line_height_unit_responsive == '' && $settings->btn_line_height_unit_medium == '' && $settings->btn_line_height_unit == '' ) { ?>
				    line-height: <?php echo $settings->btn_line_height['small']; ?>px;
			<?php } ?>

            <?php if( $converted === 'yes' || isset( $settings->btn_line_height_unit_responsive ) && $settings->btn_line_height_unit_responsive != '' ) { ?>
                line-height: <?php echo $settings->btn_line_height_unit_responsive; ?>em;
            <?php } else if( isset( $settings->btn_line_height_unit_responsive )&& $settings->btn_line_height_unit_responsive == '' && isset( $settings->btn_line_height['small'] ) && $settings->btn_line_height['small'] != '' ) {?>
                line-height: <?php echo $settings->btn_line_height['small']; ?>px;
            <?php } ?>            
        }

		.fl-node-<?php echo $id; ?> .uabb-gf-style form:not(input) {

            <?php if( $converted === 'yes' || isset( $settings->label_font_size_unit_responsive ) && $settings->label_font_size_unit_responsive != '' ) { ?>
                font-size: <?php echo $settings->label_font_size_unit_responsive; ?>px;     
            <?php } else if(isset( $settings->label_font_size_unit_responsive ) && $settings->label_font_size_unit_responsive == '' && isset( $settings->label_font_size['small'] ) && $settings->label_font_size['small'] != '') { ?>
                font-size: <?php echo $settings->label_font_size['small']; ?>px;
            <?php } ?>
		    
		    <?php if( isset( $settings->label_font_size['small'] ) && $settings->label_font_size['small'] == '' && isset( $settings->label_line_height['small'] ) && $settings->label_line_height['small'] != '' && $settings->label_line_height_unit_responsive == '' && $settings->label_line_height_unit_medium == '' && $settings->label_line_height_unit == '' ) { ?>
			    line-height: <?php echo $settings->label_line_height['small']; ?>px;
			<?php } ?>

            <?php if( $converted === 'yes' || isset( $settings->label_line_height_unit_responsive ) && $settings->label_line_height_unit_responsive != '' ) { ?>
                line-height: <?php echo $settings->label_line_height_unit_responsive; ?>em;
            <?php } else if( isset( $settings->label_line_height_unit_responsive )&& $settings->label_line_height_unit_responsive == '' && isset( $settings->label_line_height['small'] ) && $settings->label_line_height['small'] != '' ) {?>
                line-height: <?php echo $settings->label_line_height['small']; ?>px;
            <?php } ?>
            
        }

        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper div.validation_error {

            <?php 
                if(isset($settings->validation_spacing_dimension_top_responsive) ){
                    echo ( $settings->validation_spacing_dimension_top_responsive != '' ) ? 'padding-top:'.$settings->validation_spacing_dimension_top_responsive.'px;' : ''; 
                }
                if(isset($settings->validation_spacing_dimension_bottom_responsive) ){
                    echo ( $settings->validation_spacing_dimension_bottom_responsive != '' ) ? 'padding-bottom:'.$settings->validation_spacing_dimension_bottom_responsive.'px;' : '';
                }
                if(isset($settings->validation_spacing_dimension_left_responsive) ){
                    echo ( $settings->validation_spacing_dimension_left_responsive != '' ) ? 'padding-left:'.$settings->validation_spacing_dimension_left_responsive.'px;' : '';
                }
                if(isset($settings->validation_spacing_dimension_right_responsive) ){
                    echo ( $settings->validation_spacing_dimension_right_responsive != '' ) ? 'padding-right:'.$settings->validation_spacing_dimension_right_responsive.'px;' : '';
                } 
            ?>
        }

        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=tel],
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=email],
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=text],
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=url],
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=number],
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=date],
        .fl-node-<?php echo $id; ?> .uabb-gf-style select,
        .fl-node-<?php echo $id; ?> .uabb-gf-style textarea,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=tel]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=email]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=text]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=url]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=number]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style input[type=date]:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style select:focus,
        .fl-node-<?php echo $id; ?> .uabb-gf-style textarea:focus,
        .gform_wrapper .ginput_container_select .chosen-container-single .chosen-single {
            <?php 
                if(isset($settings->input_border_width_dimension_top_responsive) ){
                    echo ( $settings->input_border_width_dimension_top_responsive != '' ) ? 'padding-top:'.$settings->input_border_width_dimension_top_responsive.'px;' : ''; 
                }
                if(isset($settings->input_border_width_dimension_bottom_responsive) ){
                    echo ( $settings->input_border_width_dimension_bottom_responsive != '' ) ? 'padding-bottom:'.$settings->input_border_width_dimension_bottom_responsive.'px;' : '';
                }
                if(isset($settings->input_border_width_dimension_left_responsive) ){
                    echo ( $settings->input_border_width_dimension_left_responsive != '' ) ? 'padding-left:'.$settings->input_border_width_dimension_left_responsive.'px;' : '';
                }
                if(isset($settings->input_border_width_dimension_right_responsive) ){
                    echo ( $settings->input_border_width_dimension_right_responsive != '' ) ? 'padding-right:'.$settings->input_border_width_dimension_right_responsive.'px;' : '';
                } 
            ?>
        }


        .fl-node-<?php echo $id; ?> .uabb-gf-style .gform_wrapper form .gform_body input:not([type='radio']):not([type='checkbox']):not([type='submit']):not([type='button']):not([type='image']):not([type='file']),
        .fl-node-<?php echo $id; ?> .gform_wrapper textarea,
        .fl-node-<?php echo $id; ?> .gform_wrapper .gfield .ginput_container select,
        .gform_wrapper .ginput_container_select .chosen-container-single .chosen-single {
            <?php 
                if(isset($settings->input_padding_dimension_top_responsive) ){
                    echo ( $settings->input_padding_dimension_top_responsive != '' ) ? 'padding-top:'.$settings->input_padding_dimension_top_responsive.'px;' : ''; 
                }
                if(isset($settings->input_padding_dimension_bottom_responsive) ){
                    echo ( $settings->input_padding_dimension_bottom_responsive != '' ) ? 'padding-bottom:'.$settings->input_padding_dimension_bottom_responsive.'px;' : '';
                }
                if(isset($settings->input_padding_dimension_left_responsive) ){
                    echo ( $settings->input_padding_dimension_left_responsive != '' ) ? 'padding-left:'.$settings->input_padding_dimension_left_responsive.'px;' : '';
                }
                if(isset($settings->input_padding_dimension_right_responsive) ){
                    echo ( $settings->input_padding_dimension_right_responsive != '' ) ? 'padding-right:'.$settings->input_padding_dimension_right_responsive.'px;' : '';
                } 
            ?>
        }

        .fl-node-<?php echo $id; ?> .uabb-gf-style {
            <?php 
                if(isset($settings->form_spacing_dimension_top_responsive) ){
                    echo ( $settings->form_spacing_dimension_top_responsive != '' ) ? 'padding-top:'.$settings->form_spacing_dimension_top_responsive.'px;' : ''; 
                }
                if(isset($settings->form_spacing_dimension_bottom_responsive) ){
                    echo ( $settings->form_spacing_dimension_bottom_responsive != '' ) ? 'padding-bottom:'.$settings->form_spacing_dimension_bottom_responsive.'px;' : '';
                }
                if(isset($settings->form_spacing_dimension_left_responsive) ){
                    echo ( $settings->form_spacing_dimension_left_responsive != '' ) ? 'padding-left:'.$settings->form_spacing_dimension_left_responsive.'px;' : '';
                }
                if(isset($settings->form_spacing_dimension_right_responsive) ){
                    echo ( $settings->form_spacing_dimension_right_responsive != '' ) ? 'padding-right:'.$settings->form_spacing_dimension_right_responsive.'px;' : '';
                } 
            ?>
        }
    }
    <?php
}
?>
