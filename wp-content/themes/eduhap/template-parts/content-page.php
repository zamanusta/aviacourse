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
		<?php if(has_post_thumbnail()){ ?>
			<div class="post-thumb">
				<?php the_post_thumbnail('eduhap_blog');?>
			</div>
		<?php } ?>

			<div class="single-post-content">
				<div class="post-meta">
				<div class="row">
					<div class="col-xl-7 col-lg-7 col-md-7">
						<ul>
							<li><?php echo esc_html__('Written' , 'eduhap');?> <?php eduhap_posted_by();?></li>
							<li><?php echo get_the_time('M d, Y');?></li>
						</ul>
					</div>
					<div class="col-xl-5 col-lg-5 col-md-5">
						<div class="blog-comment">
							<h3><i class="fa fa-comments"></i> <?php comments_popup_link( esc_html__( '0 comment', 'eduhap' ), esc_html__( '1 Comment', 'eduhap' ), esc_html__( '% Comments', 'eduhap' ) ); ?></h3> 
						</div>
					</div>
				</div>
			</div>

			<?php the_content();?>
		</div>

	</div>

</article>
