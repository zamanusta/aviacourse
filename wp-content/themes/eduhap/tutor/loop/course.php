<?php
/**
 * A single course loop
 *
 * @package Tutor\Templates
 * @subpackage CourseLoopPart
 * @author Themeum <support@themeum.com>
 * @link https://themeum.com
 * @since 1.4.3
 */
 
$course_id         = get_the_ID();
$course_students   = apply_filters( 'tutor_course_students', tutor_utils()->count_enrolled_users_by_course( $course_id ), $course_id );
$course_lesson = get_post_meta(get_the_ID(),'_eduhap_course_lesson', true);
$course_duration = get_tutor_course_duration_context( $course_id, true );

?>
<div class="course-block">
	<div class="course-img">

		<?php the_post_thumbnail('eduhap_course');?>

		<div class="course-price2">
			<?php
				$price = tutor_utils()->get_course_price();
			if ( null === $price ) {
				esc_html_e( 'Free', 'eduhap' );
			} else {
				echo wp_kses_post( tutor_utils()->get_course_price() );
			}
			?>		
		</div>   
	</div>
	
	<div class="course-content">
		<div class="course-meta">
			<span class="course-student"><i class="fa fa-user-alt"></i> <?php echo esc_html( $course_students ); ?> <?php echo esc_html__('Students' , 'eduhap');?></span>
			<span class="course-duration"><i class="far fa-file-alt"></i> <?php echo esc_html( tutor_utils()->get_lesson_count_by_course( $course_id ) ) ?> <?php echo esc_html__('Lessons' , 'eduhap');?></span>
			<?php if($course_duration): ?>
			<span class="course-duration"><i class="far fa-clock"></i> <?php echo eduhap_wp_kses($course_duration) ; ?></span>
			<?php endif; ?>
			
			<div class="course_rating mb-10">
				<?php
				$course_rating = tutor_utils()->get_course_rating( $course_id );
				tutor_utils()->star_rating_generator( $course_rating->rating_avg ); ?>

				<span><?php echo $course_rating->rating_avg;?> (<?php esc_html_e( $course_rating->rating_count ); ?> <?php esc_html_e('reviews' , 'eduhap');?>)</span>
			</div>
		</div>
		
		<h4><a href="<?php the_permalink();?>"><?php echo the_title();?></a></h4>    
		<p><?php echo eduhap_trip_content(13);?></p>
	</div>
</div>