<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package likhun
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function likhun_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'likhun_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function likhun_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'likhun_pingback_header' );

/**
 * Count post words
 */
if ( !function_exists( 'likhun_count_content_words' ) ):
	function likhun_count_content_words( $content ) {

		$decode_content = html_entity_decode( $content );
		$filter_shortcode = do_shortcode( $decode_content );
		$strip_tags = wp_strip_all_tags( $filter_shortcode, true );
		$count = str_word_count( $strip_tags );
		
		return $count;
	}
endif;

/**
 * HTML tag compatible data validation
 */
function likhun_kses_allowed_html( $tags, $context ) {
	switch( $context ) {
	  case 'allowed_html': 
		$tags = array(
		  'a'      => [
			  'href'  => [],
			  'title' => [],
		  ],
		  'br'     => [],
		  'em'     => [],
		  'strong' => [],
		  'b' => [],
		  'span' => [],
		  'del' => [],
		);
		return $tags;
	  default: 
		return $tags;
	}
}
add_filter( 'wp_kses_allowed_html', 'likhun_kses_allowed_html', 10, 2 );
  
// Remove all script and style type as w3valitator
function likhun_buffer_start() { 
	ob_start( 'likhun_callback' ); 
}
add_action('wp_loaded', 'likhun_buffer_start');
  
function likhun_callback( $buffer ) {
	return preg_replace( "%[ ]type=[\'\"]text\/(javascript|css)[\'\"]%", ' ', $buffer );
}

/**
 * Page view count function
 */
if ( !function_exists( 'likhun_post_view_count_func' ) ):
    function likhun_post_view_count_func( $post_id ) {
        $count_key = 'likhun_post_views_count';
        $count = get_post_meta( $post_id, $count_key, true );
        if ( $count == '' ) {
            $count = 0;
            delete_post_meta( $post_id, $count_key );
            add_post_meta( $post_id, $count_key, '0' );
        } else {
            $count++;
            update_post_meta( $post_id, $count_key, $count );
        }
    }
endif;

/**
 * Related blog function
 * @$title @$max_post
 */
if ( ! function_exists( 'likhun_blog_related_post' ) ) :
	function likhun_blog_related_post( $title = '', $max_post = '' ){ 

		global $post;

		$terms = get_the_terms( $post->ID , 'category' );
		
		$cat_name = '';
		// Loop over each item since it's an array
		if ( $terms != null ){
			foreach( $terms as $term ) {
				// Print the name method from $term which is an OBJECT
				$cat_name = $term->name ;
				// Get rid of the other data stored in the object, since it's not needed
				unset($term);
			} 
		}

		if( $cat_name ) {
			
			$args = array(
				'post_type'           => 'post',
				'ignore_sticky_posts' => true,
				'post__not_in'        => array( $post->ID ),
				'posts_per_page'      => $max_post,
				'orderby'             => 'rand',
			);

			$wp_query = new wp_query( $args );

			ob_start();	// Output buffering
			
			?>	

			<div class="related-articles">			
				<div class="row">

					<?php if( $title ): ?>
						<div class="col-md-12">
							<div class="title-left">
								<h2><?php echo esc_html( $title ); ?></h2>
							</div>                    
						</div>
					<?php endif; ?>

					<div class="col-md-12">
						<div class="row">  

							<?php 
				
							if( $wp_query->have_posts() ):
								while ( $wp_query->have_posts() ) : 
									$wp_query -> the_post(); 
									
									/**
									 * Read time count
									 */
									$post_object = get_post( $post->ID );
									$content = $post_object->post_content;
									$word_count = likhun_count_content_words( $content );
									$time = ceil( $word_count / 280 );

									?>
									
									<div class="col-lg-4">
										<div class="row single-blog">
											
											<?php if( has_post_thumbnail() ): ?>
											<div class="col-md-8">
												<div class="blog-content">													

													<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title(); ?></a>

													<div class="pub-meta">
														<span class="pub-author">
															<i class="bi bi-clock"></i> <?php echo esc_html( $time ) .esc_html__( ' min read', 'likhun' ); ?>
														</span>
														<span class="pub-date">
															<i class="bi bi-pencil"></i> <?php the_time('d M, Y');?>
														</span>
													</div>

												</div>
											</div>
											<div class="col-md-4">
												<div class="blog-thumbnail">
													<a href="<?php the_permalink();?>">
														<?php the_post_thumbnail();?>
													</a>
												</div>
											</div>

											<?php else: ?>

											<div class="col-md-12">
												<div class="blog-content">													

													<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title(); ?></a>

													<div class="pub-meta">
														<span class="pub-author">
															<i class="bi bi-clock"></i> <?php echo esc_html( $time ) .esc_html__( ' min read', 'likhun' ); ?>
														</span>
														<span class="pub-date">
															<i class="bi bi-pencil"></i> <?php the_time('d M, Y');?>
														</span>
													</div>

												</div>
											</div>
											<?php endif; ?>

										</div>
									</div>									  

									<?php 									
								endwhile; 
								wp_reset_postdata();
							else: ?>            
							
							<h3><?php echo esc_html__( 'No related post.','likhun' ); ?></h3>
							
							<?php endif; ?>   

						</div>
					</div>
				</div>			
			</div>

			<?php 
		}

		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
endif;

/**
 * Popular post function
 * @$title @$max_post
 */
if ( ! function_exists( 'likhun_blog_popular_post' ) ) :
	function likhun_blog_popular_post( $title = '', $max_post = '' ){ 

		global $post;
			
		$args = array(
			'post_type'           => 'post',
			'meta_key'            => 'likhun_post_views_count',
			'orderby'             => 'meta_value_num',
			'posts_per_page'      => $max_post,
			'ignore_sticky_posts' => true,
			'post__not_in'        => get_option( 'sticky_posts' ),
			'orderby'             => 'rand',
		);

		$wp_query = new wp_query( $args );

		ob_start();	// Output buffering
		
		?>	

		<div class="popular-posts">			
			<div class="row">

				<?php if( $title ): ?>
					<div class="col-md-12">
						<div class="title-left">
							<h2><i class="bi bi-lightning-charge"></i> <?php echo esc_html( $title ); ?></h2>
						</div>                    
					</div>
				<?php endif; ?>

				<div class="col-md-12">
					<div class="row">  

						<?php 
			
						if( $wp_query->have_posts() ):
							while ( $wp_query->have_posts() ) : 
								$wp_query -> the_post(); 
								
								/**
								 * Read time count
								 */
								$post_object = get_post( $post->ID );
								$content = $post_object->post_content;
								$word_count = likhun_count_content_words( $content );
								$time = ceil( $word_count / 280 );

								?>
								
								<div class="col-lg-4">
									<div class="row single-blog">										
										<?php if( has_post_thumbnail() ): ?>
											<div class="col-md-4">
												<div class="blog-thumbnail">
													<a href="<?php the_permalink();?>">
														<?php the_post_thumbnail();?>
													</a>
												</div>
											</div>
											<div class="col-md-8">
												<div class="blog-content">
													<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title(); ?></a>
													<div class="pub-meta">
														<span class="pub-author">
															<i class="bi bi-clock"></i> <?php echo esc_html( $time ) .esc_html__( ' min read', 'likhun' ); ?>
														</span>
														<span class="pub-date">
															<i class="bi bi-pencil"></i> <?php the_time('d M, Y');?>
														</span>
													</div>

												</div>
											</div>										
										<?php else: ?>
											<div class="col-md-12">
												<div class="blog-content">													

													<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title(); ?></a>

													<div class="pub-meta">
														<span class="pub-author">
															<i class="bi bi-clock"></i> <?php echo esc_html( $time ) .esc_html__( ' min read', 'likhun' ); ?>
														</span>
														<span class="pub-date">
															<i class="bi bi-pencil"></i> <?php the_time('d M, Y');?>
														</span>
													</div>

												</div>
											</div>
										<?php endif; ?>

									</div>
								</div>									  

								<?php 									
							endwhile; 
							wp_reset_postdata();
						else: ?>            
						
						<h3><?php echo esc_html__( 'No trending post.','likhun' ); ?></h3>
						
						<?php endif; ?>   

					</div>
				</div>
			</div>			
		</div>

		<?php 

		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
endif;

/**
 * Ajax Pagination
 */
if ( !function_exists( 'likhun_ajax_pager' ) ):
	function likhun_ajax_pager( $query = null, $paged = 1 ) {

		if (!$query)
			return;

		$paginate = paginate_links([
			'base'      => '%_%',
			'type'      => 'array',
			'total'     => $query->max_num_pages,
			'format'    => '#page=%#%',
			'current'   => max( 1, $paged ),
			'prev_text' => esc_html__( 'Prev', 'likhun' ),
			'next_text' => esc_html__( 'Next', 'likhun' )
		]);

		if ($query->max_num_pages > 1) : ?>
			<div class="col-md-12">
				<ul class="pagination">
					<?php foreach ( $paginate as $page ) :?>
						<li><?php echo wp_kses_post( $page ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif;
	}
endif;

/***
 * Post query
 */
function likhun_filter_products() {

    if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'filterObj' ) )
        die( esc_html__( 'Permission denied', 'likhun' ));

    /**
     * Default response
     */
    $response = [
        'status'  => 500,
        'message' => esc_html__( 'Something is wrong, please try again later ...', 'likhun' ),
        'content' => false,
        'found'   => 0
    ];

    /**
     * Collecting data from params
     */
    $tax  = sanitize_text_field($_POST['params']['tax']);
    $term = sanitize_text_field($_POST['params']['term']);
    $page = intval($_POST['params']['page']);
    $qty  = intval($_POST['params']['qty']);

    /**
     * Check if term exists
     */
    if (!term_exists( $term, $tax) && $term != 'all-terms') :
        $response = [
            'status'  => 501,
            'message' => esc_html__( 'Term doesn\'t exist', 'likhun' ),
            'content' => 0
        ];

        die(json_encode($response));
    endif;

    /**
     * Tax query
     */
    if ($term == 'all-terms') : 

        $tax_qry[] = [
            'taxonomy' => $tax,
            'field'    => 'slug',
            'terms'    => $term,
            'operator' => 'NOT IN'
        ];
    else :

        $tax_qry[] = [
            'taxonomy' => $tax,
            'field'    => 'slug',
            'terms'    => $term,
        ];
    endif;

    /**
     * Setup query
     */
    $args = [
        'paged'          => $page,
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $qty,
        'tax_query'      => $tax_qry
    ];

    $qry = new WP_Query($args);
    global $post;
    
    ob_start();

        if ($qry->have_posts()) : 
            
            while ($qry->have_posts()) : $qry->the_post(); 
            
                /*
                * Include the Post-Type-specific template for the content.
                * If you want to override this in a child theme, then include a file
                * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                */
				if( get_theme_mod( 'content_style', 1 ) == 1 ):
                	get_template_part( 'template-parts/content', 'excerpt' );
				else:        
                	get_template_part( 'template-parts/content', 'masonry' );
				endif;
				
            endwhile; 

            /**
             * Pagination
             */
            likhun_ajax_pager($qry,$page);

            $response = [
                'status'=> 200,
                'found' => $qry->found_posts
            ];
            
        else :

            $response = [
                'status'  => 201,
                'message' => esc_html__( 'No posts found', 'likhun' )
            ];

        endif;

    $response['content'] = ob_get_clean();

    die(json_encode($response));

}
add_action('wp_ajax_do_filter_products', 'likhun_filter_products');
add_action('wp_ajax_nopriv_do_filter_products', 'likhun_filter_products');

/**
 * Ajax filter function
 */
if ( ! function_exists( 'likhun_ajax_filter_product' ) ) :
	function likhun_ajax_filter_product( $tax = 'category', $terms = false, $term_id = '', $active = false, $per_page = 10, $pager = 'pager' ) {

		$result = NULL;
		$terms  = get_terms( $tax, [ 'include' => $term_id ] );

		if (count($terms)) :
			ob_start(); ?>
				<div id="container-async" data-paged="<?php echo esc_attr( $per_page ); ?>" class="likhun-ajax-filter">

					<div class="row">
						<div class="col-md-12">
							<ul class="nav-filter <?php if( get_theme_mod( 'cat_menu_show' ) == 2 ): echo "menu-hide"; endif; // ajax menu checking ?>">
								<li>
									<a class="filter" href="#" data-filter="<?php echo esc_attr( $terms[0]->taxonomy ); ?>" data-term="all-terms" data-page="1">
										<?php esc_html_e( 'All', 'likhun' ); ?>
									</a>
								</li>
								<?php foreach ($terms as $term) : ?>
									<li<?php if ($term->term_id == $active ) :?> class="active" <?php endif; ?>>
										<a class="filter" href="<?php echo esc_url( get_term_link( $term, $term->taxonomy )); ?>" data-filter="<?php echo esc_attr( $term->taxonomy ); ?>" data-term="<?php echo esc_attr( $term->slug ); ?>" data-page="1">
											<?php echo esc_html( $term->name ); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>				
					
					<?php if( get_theme_mod( 'ajax_load_status' ) == 1 ): // Start ajax status message checking ?>					
						<div class="status"></div>
					<?php endif; // End ajax status message checking ?>
					
					<div class="product-container<?php if( get_theme_mod( 'content_style' ) == 2 ): ?> row masonry-style<?php endif; ?>"></div>					
					
					<?php if ( 'infscr' == $pager ) : ?>
						<nav class="pagination infscr-pager">
							<a href="#page-2" class="likhun-primary"><?php esc_html_e( 'Load More','likhun' ); ?></a>
						</nav>
					<?php endif; ?>					
					
				</div>
			
			<?php $result = ob_get_clean();
		endif;

		return $result;
	}
endif;

