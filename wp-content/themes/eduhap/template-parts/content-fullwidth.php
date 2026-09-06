<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eduhap
 */

?>

<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eduhap
 */

?>

<article id="post-<?php the_ID(); ?>" class="single-post-details">
	<div class="post-single">
		<?php the_content();?>
	</div>
</article>
