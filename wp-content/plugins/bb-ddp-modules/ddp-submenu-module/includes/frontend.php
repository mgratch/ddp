<?php
global $post;

$topParentPostID = $post->ID;
if($post->post_parent != 0){
	$topParentPostID = get_top_parent_id($post);
}
$color = get_post_meta($topParentPostID, 'page_color', true);
$color = !empty($color) ? esc_attr($color) : 'color-2';

?>
<ul class="widgets">
	<?php
	$strHtml = '';

	$strHtml .= '<li class="widget widget--side-menu widget--'.$color.'">';
	$strHtml .= '<div class="title title--bkg-'.$color.'"><span>'.get_the_title($topParentPostID).'</span></div>';
	$strHtml .= get_submenu($topParentPostID);
	$strHtml .= '</li>';

	echo $strHtml;
	?>
</ul>
