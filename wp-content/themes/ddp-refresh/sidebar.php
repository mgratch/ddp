<aside class="aside aside--main table__item">
	<ul class="widgets">
    <?php
      global $topParentTitle, $topParentPostID, $topParentPostMeta;
      $strHtml = '';

      $strHtml .= '<li class="widget widget--side-menu widget--'.$topParentPostMeta['page_color'].'">';
        $strHtml .= '<div class="title title--bkg-'.$topParentPostMeta['page_color'].'"><span>'.$topParentTitle.'</span></div>';
        $strHtml .= get_submenu($topParentPostID);
      $strHtml .= '</li>';

      echo $strHtml;
    ?>
  	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
  	<?php endif; ?>
	</ul>
</aside>