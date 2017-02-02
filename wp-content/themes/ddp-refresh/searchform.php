<?php 
 $searchTerm = 'Search';
 if(get_search_query() != ''){
 	$searchTerm = get_search_query();
 }

?>

<form id="site-search" method="get" action="<?php bloginfo('url'); ?>/">
	<label for="s" class="visuallyhidden">Search the site: </label>
	<input type="text" id="s" name="s" value="<?php echo $searchTerm; ?>" >
	<input type="submit" value="">
</form>