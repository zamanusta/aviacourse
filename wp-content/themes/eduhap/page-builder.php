<?php
/**
Template Name: Page Builder Template
 */

get_header();

$eduhap_rev_alias =  get_post_meta(get_the_ID(),'_eduhap_rev_slider_alias',true); 

if($eduhap_rev_alias){
 if (class_exists('RevSlider')) putRevSlider($eduhap_rev_alias);
}

$eduhap_hide_banner = get_post_meta(get_the_ID(), '_eduhap_hide_banner', true);

if($eduhap_hide_banner == true){
	
}else{
	eduhap_single_banner();
}
?>

<div class="page-builder-template">
	<?php
	while ( have_posts() ) :
		the_post();

		the_content();

	endwhile; // End of the loop. ?>
						
</div>

<?php

get_footer();