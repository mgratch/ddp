<aside class="aside aside--main content-columned__item">
	<ul>
    <?php
      global $topParentTitle, $topParentPostID, $topParentPostMeta;
      $strHtml = '';

      $strHtml .= '<li class="widget widget--'.$topParentPostMeta['page_color'].'">';
        $strHtml .= '<div class="title title--bkg-'.$topParentPostMeta['page_color'].'">'.$topParentTitle.'</div>';
        $strHtml .= get_submenu($topParentPostID);
      $strHtml .= '</li>';

      echo $strHtml;
    ?>
  	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
  	<?php endif; ?>
	</ul>
</aside>