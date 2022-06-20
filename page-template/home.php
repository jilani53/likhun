<?php
/**
 * Template Name: Home Default
 *
 * @package Likhun
**/

get_header(); ?>

<header class="page-header likhun-page-header">
	<div class="container">
		<div class="row align-items-center">			
			<div class="col-md-8">
				<?php if( get_theme_mod('main_title') ): ?>
					<h1 class="page-title">
						<?php echo wpautop( likhun_allowed_html( get_theme_mod( 'main_title' ) )); ?>
					</h1>
				<?php 
				endif;
					if( get_theme_mod('sub_title') ): ?><p><?php echo wpautop( likhun_allowed_html( get_theme_mod( 'sub_title' ) )); ?></p>
				<?php endif; ?>
			</div>
			<div class="col-md-4 hero-banner">
				<?php if( get_theme_mod( 'hero_banner' ) ):	?>
					<img class="hero-right-banner" src="<?php echo esc_url( get_theme_mod( 'hero_banner' ) ); ?>" alt="<?php echo esc_attr( get_theme_mod( 'main_title' ) ); ?>"/>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header><!-- .page-header -->

<div class="likhun-main-body <?php if( get_theme_mod( 'content_style' ) == 2 ): ?> margin-bottom-5x <?php endif; ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php 
				/**
				 * Most popular/trending posts functions
				 */
				if ( function_exists( 'likhun_ajax_filter_product' ) ):
					echo likhun_blog_popular_post( get_theme_mod( 'popular_post_title' ), get_theme_mod( 'max_popular_post_show' ) ); 
				endif;
				?>
			</div>
			<div class="col-md-8">
				<?php 
				/**
				 * Ajax post display function
				 */
				if ( function_exists( 'likhun_ajax_filter_product' ) ):
					echo likhun_ajax_filter_product( $tax = 'category', $terms = false, $term_id = '', $active = false, $per_page = get_theme_mod( 'max_ajax_post_show' ), $pager = 'pager' );
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

<?php get_footer();
