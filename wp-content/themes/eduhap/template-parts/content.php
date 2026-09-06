<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eduhap
 */

?>

<article id="post-<?php the_ID(); ?>" class="blog-post-item">
	<?php if(has_post_thumbnail()){ ?>
		<div class="post-thumb">
			<?php the_post_thumbnail('eduhap_blog');?>
		</div>
	<?php } ?>
	<div class="post-item mt-4">
		<div class="post-meta">
			<span class="post-author"><i class="fa fa-user me-2"></i> <?php eduhap_posted_by();?></span>
			<span class="post-date"><i class="fa fa-calendar-alt me-2"></i><?php echo get_the_time('M d, Y');?></span>
		</div>
		<h2 class="post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
		<div class="post-content">
			<?php the_excerpt();?>

			<a href="<?php the_permalink();?>" class="read-more"><?php esc_html_e('More Details' , 'eduhap');?> <i class="fa fa-angle-right ms-2"></i></a>
		<?php wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eduhap' ),
				'after'  => '</div>',
			)
		); ?>
		</div>
	</div>
</article>