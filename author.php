<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package likhun
 */

get_header();

// Collect author name
$curauth = ( isset( $_GET['author_name'] )) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ));

?>

<header class="page-header likhun-page-header">
	<div class="container">
		<div class="row">			
			<div class="col-md-12">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'About: %s', 'likhun' ), '<span>' . $curauth->display_name . '</span>' );
					?>
				</h1>
			</div>
		</div>
	</div>
</header><!-- .page-header -->

<div class="likhun-main-body">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?php if( get_theme_mod( 'ark_content_style' ) == 2 ): ?><div class="row masonry-style"><?php endif;

					// Have post
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
							if( get_theme_mod( 'ark_content_style', 1 ) == 1 ):
								get_template_part( 'template-parts/content', 'excerpt' );
							else:        
								get_template_part( 'template-parts/content', 'masonry' );
							endif;

						endwhile;

						// Start pagination
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
				
				// Masonry end div
				if( get_theme_mod( 'ark_content_style' ) == 2 ): ?></div><?php endif; ?>
			</div>
			<div class="col-md-4">
				<div class="likhun-sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();