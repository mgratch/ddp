<aside class="main">
    <?php 
    global $topParentTitle, $topParentPostID;
    
    echo '<div style="color:red;">'.$topParentTitle.'</div>';
    
    
    ?>


	<ul>
		<li>
			<?php  echo get_submenu($topParentPostID); ?>
		</li>
	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
	<?php endif; ?>
	</ul>
</aside>