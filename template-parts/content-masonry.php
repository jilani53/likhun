<?php
/**
 * Template part for displaying results in pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package likhun
 */

?>

<div class="col-md-6">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php likhun_post_thumbnail(); ?>
        <header class="entry-header">
            <?php
            
            // Post title
            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;

            // If post type
            if ( 'post' === get_post_type() ) : ?>
                <div class="entry-meta">
                    <?php
                        likhun_posted_on();
                        likhun_posted_by();
                    ?>
                </div><!-- .entry-meta -->
            <?php endif; ?>
            
        </header><!-- .entry-header -->

        <?php if( get_theme_mod( 'excerpt_display', 1 ) == 1 ): ?>
            <div class="entry-summary">
                <?php the_excerpt(); ?>
            </div><!-- .entry-summary -->
        <?php endif; ?>

    </article><!-- #post-<?php the_ID(); ?> -->
</div>
