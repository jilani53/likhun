<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package likhun
 */

get_header();
?>

<div class="likhun-main-body">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?php
				if ( have_posts() ) :

					if ( is_home() && ! is_front_page() ) :
						?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
						<?php
					endif;

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						* Include the Post-Type-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Type name) and that will be used instead.
						*/
						get_template_part( 'template-parts/content', 'excerpt' );

					endwhile;

					if( paginate_links() ): ?>					
						<div class="likhun-pagination">
							<ul class="pagination">
								<li>
								<?php
						
								$big = 999999999; // need an unlikely integer

								echo paginate_links(
									array (
									'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
									'format'    => '?paged=%#%',
									'current'   => max(1, get_query_var('paged')),
									'total'     => $wp_query->max_num_pages,
									'type'      => '',
									'prev_text' => '<i class="bi bi-arrow-left"></i>',
									'next_text' => '<i class="bi bi-arrow-right"></i>',
								));

								?>
								</li>
							</ul>
						</div>
					<?php

					endif; // End pagina checking

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div>
			<div class="col-md-4">
				<aside class="likhun-sidebar">
					<?php get_sidebar(); ?>
				</aside>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
