<?php
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

if ( $parent_id != 0 ) {
	$current_post_id = get_top_parent_id( $post );
}
$color = get_post_meta( $current_post_id, 'page_color', true );
$color = ! empty( $color ) ? esc_attr( $color ) : 'color-2';
$topParentTitle = get_the_title($current_post_id);
?>
<ul class="widgets">
	<?php
	$strHtml = '';

	$strHtml .= '<li class="widget widget--side-menu widget--'.$color.'">';
	$strHtml .= '<div class="title title--bkg-'.$color.'"><span>'.$topParentTitle.'</span></div>';
	$strHtml .= ddp_get_submenu($current_post_id);
	$strHtml .= '</li>';

	echo $strHtml;
	?>
</ul>
