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
	<hr>		
			<div class="post-taxonomies">
  
  <?php the_terms( get_the_ID(), 'post_tag', '<b>Tags:</b> ', ', ' ); ?>
</div>
	</div>

		<div class="article-share">

		</div>

		<div class="author">
			<div class="author-img">
				<?php echo get_avatar( get_the_author_meta('email') , 90 ); ?>
			</div>
			<div class="author-info">
				<h4><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"><?php the_author(); ?></a></h4>
				<p><?php echo get_the_author_meta('designation');?></p> 
				<p><?php echo get_the_author_meta('description');?></p>
				<ul class="list-inline">
                    <li class="list-inline-item"><a href="<?php echo esc_url(get_the_author_meta('facebook_link'));?>"><i class="fab fa-facebook"></i></a></li>
                    <li class="list-inline-item"><a href="<?php echo esc_url(get_the_author_meta('twitter_link'));?>"><i class="fab fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="<?php echo esc_url(get_the_author_meta('linkedin_link'));?>"><i class="fab fa-linkedin"></i></a></li>
                    <li class="list-inline-item"><a href="<?php echo esc_url(get_the_author_meta('youtube_link'));?>"><i class="fab fa-youtube"></i></a></li>
                </ul>
			</div>
		</div>  
	</div>

</article>