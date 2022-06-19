<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package likhun
 */

get_header();

/**
 * Page view count
 */
if ( function_exists( 'likhun_post_view_count_func' ) ){
    likhun_post_view_count_func( get_the_ID() );
}

/**
 * Single page layout meta
 */
?>

<div class="likhun-main-body">
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', get_post_type() );

					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'likhun' ) . '</span> <span class="nav-title">%title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'likhun' ) . '</span> <span class="nav-title">%title</span>',
						)
					);

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
			</div>

			<?php 
			if( get_theme_mod( 'related_post_title' ) ):
				echo likhun_blog_related_post( get_theme_mod( 'related_post_title' ), get_theme_mod( 'max_related_post_show' ) ); 
			endif;
			?>
			
		</div>
	</div>
</div>

<?php
get_footer();
