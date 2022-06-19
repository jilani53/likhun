<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package likhun
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Main Body -->
<div class="likhun-header-container">

	<!-- Header Alert -->
	<?php if( get_theme_mod( 'alert_show' ) == 1 ): ?>
		<div class="likhun-alert alert alert-warning alert-dismissible fade show" role="alert">
			<?php echo wp_kses_post( get_theme_mod( 'alert_text' ) ); ?>
			<?php if( get_theme_mod( 'offer_schedule' ) ): ?>
				<div id="likhun-countdown" offerDate="<?php echo esc_attr( get_theme_mod( 'offer_schedule' )); ?>"></div>
			<?php endif; ?>
			<a type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x-lg"></i></a>
		</div>
	<?php endif; ?>

	<!-- Main Header -->
	<header class="likhun-header">

		<!-- Main Navbar -->
		<nav class="navbar navbar-expand-lg navbar-light likhun-nav">
			<div class="container">

				<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php 

					$likhun_logo_id = get_theme_mod( 'custom_logo' );
					$logo_url = wp_get_attachment_image_src( $likhun_logo_id , 'full' );					

					if( function_exists ( 'the_custom_logo'  ) && has_custom_logo() ): 
						echo '<img class="likhun-logo likhun-dark" src="'.esc_url( $logo_url[0] ).'" alt="'.esc_attr( get_bloginfo( 'name' ) ).'"/>';
					else: 
						bloginfo( 'name' ); 
					endif; ?>

					<?php if( get_theme_mod( 'light_logo_upload' ) ):	?>
						<img class="likhun-logo likhun-light" src="<?php echo esc_url( get_theme_mod( 'light_logo_upload' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' )); ?>"/>
					<?php endif; ?>
				</a>
				
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<i class="bi bi-list"></i>
				</button>

				<div class="collapse navbar-collapse" id="navbarNavDropdown">
					
					<?php /* Primary navigation */
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'depth'          => 4,
								'container'      => false,
								'menu_class'     => 'navbar-nav mx-auto main-menu-nav',
								'fallback_cb'    => 'likhun_primary_menu_fallback',
								//Process nav menu using our custom nav walker
								'walker'         => new WP_Bootstrap_Navwalker(),
							)
						);
					?>

					<div class="d-flex float-right">
						
						<?php // Social icon control
						if( get_theme_mod( 'social_show' ) == 1 ): ?>
							<ul class="social-icon">
								<?php if( get_theme_mod( 'fb_social' ) ): ?>
									<li>
										<a href="<?php echo esc_url( get_theme_mod( 'fb_social', '#' ) ); ?>">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
										</a>
									</li><?php endif; ?>
								<?php if( get_theme_mod( 'tw_social' ) ): ?>
									<li>
										<a href="<?php echo esc_url( get_theme_mod( 'tw_social', '#' ) ); ?>">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
										</a>
									</li>
								<?php endif; ?>
								<?php if( get_theme_mod( 'ln_social' ) ): ?>
									<li><a href="<?php echo esc_url( get_theme_mod( 'ln_social', '#' ) ); ?>">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-linkedin"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
									</a>
								</li>
								<?php endif; ?>
								<?php if( get_theme_mod( 'gl_social' ) ): ?>
									<li>
										<a href="<?php echo esc_url( get_theme_mod( 'gl_social', '#' ) ); ?>">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-youtube"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/></svg>
										</a>
									</li>
								<?php endif; ?>
								<?php if( get_theme_mod( 'drbb_social' ) ): ?>
									<li>
										<a href="<?php echo esc_url( get_theme_mod( 'drbb_social', '#' ) ); ?>">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dribbble"><circle cx="12" cy="12" r="10"/><path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"/></svg>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						<?php 
						endif; // End social icon control ?>

						<!-- Color mode switer -->
						<div class="mode-switcher">
							<i class="bi mode-icon-change"></i>
						</div>

						<?php if( is_user_logged_in() ){ ?>

							<!-- Dropdown button -->
							<div class="likhun-user-dashboard dropdown user-dashboard">
								<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink_1" data-bs-toggle="dropdown" aria-expanded="false">
									<?php echo get_avatar( get_current_user_id(), '30', '' , '' , array( 'class' => array( 'loggedin-user-image' ) ) ); ?>	
									<?php echo esc_html( wp_get_current_user()->display_name ); ?>
								</a>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink_1">
									<li><a href="<?php echo wp_logout_url( home_url() ); ?>" class="dropdown-item"><?php esc_html_e( 'Logout', 'likhun' ); ?></a></li>
								</ul>
							</div>

						<?php } else { 
							
							if( get_theme_mod( 'btn_text') ): ?>
								<a class="likhun-primary" href="<?php echo esc_url( get_theme_mod( 'btn_url', '#' ) ); ?>">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
									<?php echo esc_html( get_theme_mod( 'btn_text', __( 'Get Started', 'likhun' ) ) ); ?>
								</a>
							<?php endif; ?>

						<?php } ?>
					</div>					
				</div>
			</div>
		</nav>

	</header><!-- #masthead -->
