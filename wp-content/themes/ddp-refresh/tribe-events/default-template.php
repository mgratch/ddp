<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

 get_header(); ?>
	<?php 
	//have to spoof the events
	$eventParentData = get_content_by_slug('events-placeholder',true);
	
	if (!empty($eventParentData)){



		$customMeta = clean_meta($eventParentData->post_custom );

		$topParentPostMeta = $customMeta;
		$topParentPostID = $eventParentData->ID;
		$topParentTitle = get_the_title($eventParentData->ID);

		//var_dump($customMeta);
	?>
	<main>
		<section class="hero hero--with-content">
			<div class="<?php echo 'hero__content hero__content--'.$topParentPostMeta['page_color']; ?>">
				<div class="content-columned content-columned--with-aside">
					<div class="content-columned__item"></div>
					<div class="content-columned__item">
						<div class="page-content">
							<h1 class="headline headline--light headline--page-main"><?php echo $topParentTitle; ?></h1>
							<?php if (!empty($customMeta['wpcf-subhead'])) {
								echo '<div class="headline headline--page-sub headline--emphasis">'.$customMeta['wpcf-subhead'].'</div>';
							} ?>
						</div>
					</div>
				</div>
			</div>
			<?php echo wp_get_attachment_image( get_post_thumbnail_id($topParentPostID), 'full', '', array('class'=>'hero__image')); ?>
		</section>
		<div class="content-columned content-columned--with-aside content-columned--top-offset">
			<?php get_sidebar(); ?>
			<section class="content-columned__item site-content">
				<article class="page-content">
	 			<div id="tribe-events-pg-template">

					<?php tribe_events_before_html(); ?>
					<?php tribe_get_view(); ?>
					<?php tribe_events_after_html(); ?>
				</div> <!-- #tribe-events-pg-template -->
	</article>
			</section><!-- ./SITE-CONTENT -->
		</div>
	</main>
	<?php } ?>
<?php get_footer();
	
?>