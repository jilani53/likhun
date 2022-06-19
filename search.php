<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package likhun
 */

get_header();
?>

<header class="page-header likhun-page-header">
	<div class="container">
		<div class="row">			
			<div class="col-md-12">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'likhun' ), '<span>' . get_search_query() . '</span>' );
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
				<?php if ( have_posts() ) : 
					
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					endwhile;

					// Pagination
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
				<div class="likhun-sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
