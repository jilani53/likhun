<?php
/**
 * Likhun Theme Customizer
 *
 * @package Likhun
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function likhun_customize_register($wp_customize) {

    /**
     * Separator control in Customizer API
    */
    class Separator_Custom_control extends WP_Customize_Control{
        public $type = 'separator';
        public function render_content(){ ?>
            <h2><?php echo esc_html( $this->label ); ?></h2>
            <p><hr></p>
        <?php
        }
    }

    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'likhun_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'likhun_customize_partial_blogdescription',
        ));
    }

    /**
     * Site identity
     */

    // Logo
    $wp_customize->add_setting( 'light_logo_upload',

        array(
            'default'           => '' . get_template_directory_uri() . '/images/logo-light.png',
            'sanitize_callback' => 'likhun_sanitize_image',
        )

    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'light_logo_upload',
            array(
                'label'    => esc_html__('Light Logo', 'likhun'),
                'section'  => 'title_tagline',
                'settings' => 'light_logo_upload',
                'priority' => '8',
            )
        )
    );

    // Sticky Logo
    $wp_customize->add_setting( 'sticky_logo_upload',

        array(
            'default'           => '' . get_template_directory_uri() . '/images/logo-light.png',
            'sanitize_callback' => 'likhun_sanitize_image',
        )

    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'sticky_logo_upload',
            array(
                'label'    => esc_html__('Sticky Logo', 'likhun'),
                'section'  => 'title_tagline',
                'settings' => 'sticky_logo_upload',
                'priority' => '8',
            )
        )
    );

    // Sticky menu show/hide
    $wp_customize->add_setting(
        'display_font',
        array(
            'default'           => '1',
            'sanitize_callback' => 'likhun_header_sanitize_radio',
        )
    );

    $wp_customize->add_control(
        'display_font',
        array(
            'type'     => 'radio',
            'label'    => esc_html__('Google font show/hide', 'likhun'),
            'section'  => 'title_tagline',
            'priority' => '20',
            'choices'  => array(
                '1' => esc_html__('Default Font ( Recommended for better performance )', 'likhun'),
                '2' => esc_html__('Google Font', 'likhun'),
            ),
        )
    );

    // Google font 
    $wp_customize->add_setting( 'google_font', array(

        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post', // Allowed HTML from content

    ) );

    $wp_customize->add_control( 'google_font', array(

        'section' => 'title_tagline',
        'priority' => '20',
        'label'   => esc_html__('Input google font. Ex: "Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"', 'likhun'),
        'type'    => 'textarea',

    ));

    // Google font family
    $wp_customize->add_setting( 'google_font_family', array(

        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post', // Allowed HTML from content

    ) );

    $wp_customize->add_control( 'google_font_family', array(

        'section' => 'title_tagline',
        'priority' => '20',
        'label'   => esc_html__('Input google font family.', 'likhun'),
        'type'    => 'textarea',

    ));

    // Body line height
    $wp_customize->add_setting( 'line_height', array(

        'default'           => 31,
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',

    ) );

    $wp_customize->add_control( 'line_height', array(

        'section' => 'title_tagline',
        'priority' => '20',
        'label'   => esc_html__('Body line height', 'likhun'),
        'type'    => 'number',

    ));

    /**
     * Header Section
     */

    // Likhun Header: Panel
    $wp_customize->add_panel('likhun_header', array(
        'priority'       => 30,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => esc_html__('Likhun Header', 'likhun'),
        'description'    => esc_html__('Change header elements.', 'likhun'),
    ));

        // Top Alert: Panel
        $wp_customize->add_section('page_alert', array(

            'title'    => esc_html__('Top Alert', 'likhun'),
            'priority' => '20',
            'panel'    => 'likhun_header',

        ));

            // Alert text
            $wp_customize->add_setting( 'alert_text', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post', // Allowed HTML from content

            ) );
            $wp_customize->add_control('alert_text', array(

                'section' => 'page_alert',
                'label'   => esc_html__('Top Deal Alert Text', 'likhun'),
                'type'    => 'textarea',

            ));

            // Alert show/hide
            $wp_customize->add_setting(
                'alert_show',
                array(
                    'default'           => '2',
                    'sanitize_callback' => 'likhun_header_sanitize_radio',
                )
            );

            $wp_customize->add_control(
                'alert_show',
                array(
                    'type'     => 'radio',
                    'label'    => esc_html__('Alert Show/Hide', 'likhun'),
                    'section'  => 'page_alert',
                    'priority' => '20',
                    'choices'  => array(
                        '1' => esc_html__('Show', 'likhun'),
                        '2' => esc_html__('Hide', 'likhun'),
                    ),
                )
            );

            // Alert text
            $wp_customize->add_setting('offer_schedule', array(

                'default'   => '',
                'transport' => 'refresh',
                'sanitize_callback' => 'likhun_sanitize_date' // Allowed HTML from content

            ));
            $wp_customize->add_control('offer_schedule', array(

                'section' => 'page_alert',
                'label'   => esc_html__('Date Schedule', 'likhun'),
                'type'    => 'date',

            ));

        // Top Menu Information: Panel
        $wp_customize->add_section('top_menu', array(

            'title'    => esc_html__('Top Menu Information', 'likhun'),
            'priority' => '20',
            'panel'    => 'likhun_header',

        ));

            // Change main menu button text
            $wp_customize->add_setting( 'btn_text', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post',

            ) );
            $wp_customize->add_control('btn_text', array(

                'section'     => 'top_menu',
                'label'       => esc_html__('Button text', 'likhun'),
                'description' => esc_html__('Main menu right button text.', 'likhun'),
                'type'        => 'text',

            ));

            // Change tom menu button url
            $wp_customize->add_setting('btn_url', array(

                'default'   => '',
                'transport' => 'refresh',
                'sanitize_callback' => 'wp_kses_post'

            ));
            $wp_customize->add_control('btn_url', array(

                'section'     => 'top_menu',
                'label'       => esc_html__('Button url', 'likhun'),
                'description' => esc_html__('Main menu right button url.', 'likhun'),
                'type'        => 'text',

            ));

            /***
            Separator
            **/
            $wp_customize->add_setting('social_separator', array(
                'default'           => '',
                'sanitize_callback' => 'esc_html',
            ));
            $wp_customize->add_control(
                new Separator_Custom_control(
                    $wp_customize, 'social_separator', array(
                        'settings'		=> 'social_separator',
                        'label'         => esc_html__('Social Settings', 'likhun'),
                        'section'  		=> 'top_menu',
                    )
                )
            );

            // Social  show/hide
            $wp_customize->add_setting(
                'social_show',
                array(
                    'default'           => '2',
                    'sanitize_callback' => 'likhun_header_sanitize_radio',
                )
            );

            $wp_customize->add_control(
                'social_show',
                array(
                    'type'     => 'radio',
                    'label'    => esc_html__('Social Show/Hide', 'likhun'),
                    'section'  => 'top_menu',
                    'choices'  => array(
                        '1' => esc_html__('Show', 'likhun'),
                        '2' => esc_html__('Hide', 'likhun'),
                    ),
                )
            );

            // Facebook social
            $wp_customize->add_setting( 'fb_social', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post',

            ) );
            $wp_customize->add_control('fb_social', array(

                'section' => 'top_menu',
                'label'   => esc_html__('Facebook url', 'likhun'),
                'type'    => 'text',

            ));

            // Twitter social
            $wp_customize->add_setting( 'tw_social', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post',

            ) );
            $wp_customize->add_control('tw_social', array(

                'section' => 'top_menu',
                'label'   => esc_html__('Twitter url', 'likhun'),
                'type'    => 'text',

            ));

            // Linkedin social
            $wp_customize->add_setting( 'ln_social', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post',

            ) );
            $wp_customize->add_control('ln_social', array(

                'section' => 'top_menu',
                'label'   => esc_html__('Linkedin url', 'likhun'),
                'type'    => 'text',

            ));

            // Google social
            $wp_customize->add_setting( 'gl_social', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post',

            ) );
            $wp_customize->add_control('gl_social', array(

                'section' => 'top_menu',
                'label'   => esc_html__('Youtube url', 'likhun'),
                'type'    => 'text',

            ));

            // Dribbble social
            $wp_customize->add_setting( 'drbb_social', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post',

            ) );
            $wp_customize->add_control('drbb_social', array(

                'section' => 'top_menu',
                'label'   => esc_html__('Dribbble url', 'likhun'),
                'type'    => 'text',

            ));

    /**
     * Settings Section
     */

    // Likhun Settings: Panel
    $wp_customize->add_panel('likhun_settings', array(
        'priority'       => 30,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => esc_html__('Likhun Settings', 'likhun'),
        'description'    => esc_html__('Several settings pertaining likhun theme', 'likhun'),
    ));

        // Global Settings: Panel
        $wp_customize->add_section('global_settings', array(

            'title'    => esc_html__('Global Settings', 'likhun'),
            'priority' => '20',
            'panel'    => 'likhun_settings',

        ));

            /***
            Archive Section Separator
            **/
            $wp_customize->add_setting('post_separator', array(
                'default'           => '',
                'sanitize_callback' => 'esc_html',
            ));
            $wp_customize->add_control(
                new Separator_Custom_control(
                    $wp_customize, 'post_separator', array(
                        'settings'		=> 'post_separator',
                        'label'         => esc_html__('Post Settings', 'likhun'),
                        'section'  		=> 'global_settings',
                    )
                )
            );

            // Archive content style
            $wp_customize->add_setting(
                'excerpt_display',
                array(
                    'default'           => '1',
                    'sanitize_callback' => 'likhun_header_sanitize_radio',
                )
            );

            $wp_customize->add_control(
                'excerpt_display',
                array(
                    'type'     => 'radio',
                    'label'    => esc_html__('Masonry Excerpt Show/Hide', 'likhun'),
                    'section'  => 'global_settings',
                    'choices'  => array(
                        '1' => esc_html__('Show', 'likhun'),
                        '2' => esc_html__('Hide', 'likhun'),
                    ),
                )
            );

        // Home Page Settings: Panel
        $wp_customize->add_section('home_settings', array(

            'title'    => esc_html__('Home Page Settings', 'likhun'),
            'priority' => '20',
            'panel'    => 'likhun_settings',

        ));

            /***
            Hero Section Separator
            **/
            $wp_customize->add_setting('hero_separator', array(
                'default'           => '',
                'sanitize_callback' => 'esc_html',
            ));
            $wp_customize->add_control(
                new Separator_Custom_control(
                    $wp_customize, 'hero_separator', array(
                        'settings'		=> 'hero_separator',
                        'label'         => esc_html__('Hero Section Settings', 'likhun'),
                        'section'  		=> 'home_settings',
                    )
                )
            );

            // Main title
            $wp_customize->add_setting( 'main_title', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post',

            ) );

            $wp_customize->add_control('main_title', array(

                'section' => 'home_settings',
                'label'   => esc_html__('Hero Main Title', 'likhun'),
                'type'    => 'textarea',

            ));

            // Sub title
            $wp_customize->add_setting( 'sub_title', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post',

            ) );
            $wp_customize->add_control('sub_title', array(

                'section' => 'home_settings',
                'label'   => esc_html__('Hero Sub Title', 'likhun'),
                'type'    => 'textarea',

            ));

            // Banner
            $wp_customize->add_setting( 'hero_banner',

                array(
                    'default'           => '' . get_template_directory_uri() . '/images/banner.jpg',
                    'sanitize_callback' => 'likhun_sanitize_image',
                )

            );

            $wp_customize->add_control(
                new WP_Customize_Image_Control(
                    $wp_customize,
                    'hero_banner',
                    array(
                        'label'    => esc_html__('Hero Right Banner', 'likhun'),
                        'section'  => 'home_settings',
                        'settings' => 'hero_banner',
                    )
                )
            );

            /***
            Trending Section Separator
            **/
            $wp_customize->add_setting('trending_separator', array(
                'default'           => '',
                'sanitize_callback' => 'esc_html',
            ));
            $wp_customize->add_control(
                new Separator_Custom_control(
                    $wp_customize, 'trending_separator', array(
                        'settings'		=> 'trending_separator',
                        'label'         => esc_html__('Trending Section Settings', 'likhun'),
                        'section'  		=> 'home_settings',
                    )
                )
            );

            // Popular post title
            $wp_customize->add_setting( 'popular_post_title', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post',

            ) );

            $wp_customize->add_control('popular_post_title', array(

                'section' => 'home_settings',
                'label'   => esc_html__('Popular Post Title', 'likhun'),
                'type'    => 'text',

            ));   
            
            // Maximum popular post show
            $wp_customize->add_setting( 'max_popular_post_show', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'absint',

            ) );

            $wp_customize->add_control('max_popular_post_show', array(

                'section' => 'home_settings',
                'label'   => esc_html__('Maximum Post Show', 'likhun'),
                'type'    => 'number',

            ));

            /***
            Ajax Section Separator
            **/
            $wp_customize->add_setting('ajax_separator', array(
                'default'           => '',
                'sanitize_callback' => 'esc_html',
            ));
            $wp_customize->add_control(
                new Separator_Custom_control(
                    $wp_customize, 'ajax_separator', array(
                        'settings'		=> 'ajax_separator',
                        'label'         => esc_html__('Ajax Section Settings', 'likhun'),
                        'section'  		=> 'home_settings',
                    )
                )
            );

            // Ajax content style
            $wp_customize->add_setting(
                'content_style',
                array(
                    'default'           => '1',
                    'sanitize_callback' => 'likhun_header_sanitize_radio',
                )
            );

            $wp_customize->add_control(
                'content_style',
                array(
                    'type'     => 'radio',
                    'label'    => esc_html__('Ajax Content Style', 'likhun'),
                    'section'  => 'home_settings',
                    'choices'  => array(
                        '1' => esc_html__('Default Style', 'likhun'),
                        '2' => esc_html__('Masonry Style', 'likhun'),
                    ),
                )
            );

            // Ajax category menu show/hide
            $wp_customize->add_setting(
                'cat_menu_show',
                array(
                    'default'           => '1',
                    'sanitize_callback' => 'likhun_header_sanitize_radio',
                )
            );

            $wp_customize->add_control(
                'cat_menu_show',
                array(
                    'type'     => 'radio',
                    'label'    => esc_html__('Ajax Category Menu  Show/Hide', 'likhun'),
                    'section'  => 'home_settings',
                    'choices'  => array(
                        '1' => esc_html__('Show', 'likhun'),
                        '2' => esc_html__('Hide', 'likhun'),
                    ),
                )
            );

            // Ajax load status show/hide
            $wp_customize->add_setting(
                'ajax_load_status',
                array(
                    'default'           => '1',
                    'sanitize_callback' => 'likhun_header_sanitize_radio',
                )
            );

            $wp_customize->add_control(
                'ajax_load_status',
                array(
                    'type'     => 'radio',
                    'label'    => esc_html__('Ajax Load Status Show/Hide', 'likhun'),
                    'section'  => 'home_settings',
                    'choices'  => array(
                        '1' => esc_html__('Show', 'likhun'),
                        '2' => esc_html__('Hide', 'likhun'),
                    ),
                )
            ); 
            
            // Maximum ajax post show
            $wp_customize->add_setting( 'max_ajax_post_show', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'absint',

            ) );

            $wp_customize->add_control('max_ajax_post_show', array(

                'section' => 'home_settings',
                'label'   => esc_html__('Maximum Ajax Post Show', 'likhun'),
                'type'    => 'number',

            ));

        // Single Page Settings: Panel
        $wp_customize->add_section('single_settings', array(

            'title'    => esc_html__('Single Page Settings', 'likhun'),
            'priority' => '20',
            'panel'    => 'likhun_settings',

        ));

            /***
            Related Section Separator
            **/
            $wp_customize->add_setting('related_post_separator', array(
                'default'           => '',
                'sanitize_callback' => 'esc_html',
            ));
            $wp_customize->add_control(
                new Separator_Custom_control(
                    $wp_customize, 'related_post_separator', array(
                        'settings'		=> 'related_post_separator',
                        'label'         => esc_html__('Related Article Settings', 'likhun'),
                        'section'  		=> 'single_settings',
                    )
                )
            );

            // Related post title
            $wp_customize->add_setting( 'related_post_title', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post',

            ) );

            $wp_customize->add_control('related_post_title', array(

                'section' => 'single_settings',
                'label'   => esc_html__('Related Post Title', 'likhun'),
                'type'    => 'text',

            ));   
            
            // Maximum related post show
            $wp_customize->add_setting( 'max_related_post_show', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'absint',

            ) );

            $wp_customize->add_control('max_related_post_show', array(

                'section' => 'single_settings',
                'label'   => esc_html__('Maximum Post Show', 'likhun'),
                'type'    => 'number',

            ));

        // Archive Settings: Panel
        $wp_customize->add_section('archive_settings', array(

            'title'    => esc_html__('Archive Settings', 'likhun'),
            'priority' => '20',
            'panel'    => 'likhun_settings',

        ));

            /***
            Archive Section Separator
            **/
            $wp_customize->add_setting('archive_separator', array(
                'default'           => '',
                'sanitize_callback' => 'esc_html',
            ));
            $wp_customize->add_control(
                new Separator_Custom_control(
                    $wp_customize, 'archive_separator', array(
                        'settings'		=> 'archive_separator',
                        'label'         => esc_html__('Archive Post Settings', 'likhun'),
                        'section'  		=> 'archive_settings',
                    )
                )
            );

            // Archive content style
            $wp_customize->add_setting(
                'ark_content_style',
                array(
                    'default'           => '1',
                    'sanitize_callback' => 'likhun_header_sanitize_radio',
                )
            );

            $wp_customize->add_control(
                'ark_content_style',
                array(
                    'type'     => 'radio',
                    'label'    => esc_html__('Archive Content Style', 'likhun'),
                    'section'  => 'archive_settings',
                    'choices'  => array(
                        '1' => esc_html__('Default Style', 'likhun'),
                        '2' => esc_html__('Masonry Style', 'likhun'),
                    ),
                )
            );

    /**
     * Footer Section
     */

    // Footer Panel
    $wp_customize->add_panel('likhun_footer', array(
        'priority'       => 30,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => esc_html__('Likhun Footer', 'likhun'),
        'description'    => esc_html__('Several settings pertaining likhun theme', 'likhun'),
    ));

        // Footer information: Panel
        $wp_customize->add_section('footer', array(

            'title'    => esc_html__('Footer Information', 'likhun'),
            'priority' => '20',
            'panel'    => 'likhun_footer',

        ));

            // Copyright text
            $wp_customize->add_setting( 'copy_text', array(

                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_kses_post',

            ) );
            $wp_customize->add_control('copy_text', array(

                'section' => 'footer',
                'label'   => esc_html__('Copyright text', 'likhun'),
                'type'    => 'textarea',

            ));            

    // Color Sanitization
    function likhun_color_sanitize_hex_color($hex_color, $setting) {
        // Sanitize $input as a hex value.
        $hex_color = sanitize_hex_color($hex_color);
        // If $input is a valid hex value, return it; otherwise, return the default.
        return (!is_null($hex_color) ? $hex_color : $setting->default);
    }

    // Radio options sanitizations
    function likhun_header_sanitize_radio($input, $setting) {
        // Ensure input is a slug.
        $input = sanitize_key($input);
        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control($setting->id)->choices;
        // If the input is a valid key, return it; otherwise, return the default.
        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }

    // File input sanitization function
    function likhun_sanitize_image( $input, $setting ) {

        $input = esc_url( $input );    
        $attrs = $setting->manager->get_control( $setting->id )->input_attrs;
        
        $extension = pathinfo( $input , PATHINFO_EXTENSION );
        
        if ( $input != $setting->default ) {
        
            if ( $extension == 'jpg' ) {
                return wp_get_attachment_image_src( attachment_url_to_postid( $input ) , $attrs['img_size'] )[0];
            } elseif ( $extension == 'jpeg' ) {
                return wp_get_attachment_image_src( attachment_url_to_postid( $input ) , $attrs['img_size'] )[0];
            } elseif ( $extension == 'png' ) {
                return wp_get_attachment_image_src( attachment_url_to_postid( $input ) , $attrs['img_size'] )[0];
            } elseif ( $extension == 'gif' ) {
                return $input;
            } elseif ( $extension == 'svg' && current_user_can('editor') || current_user_can('administrator') ) {
                return $input;
            }
            
        } else {            
            return esc_url( $setting->default );        
        }
        
    }

    // Date sanitization function
    function likhun_sanitize_date( $input ) {
        $date = new DateTime( $input );
        return $date->format('Y-m-d');
    }

}
add_action('customize_register', 'likhun_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function likhun_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function likhun_customize_partial_blogdescription() {
    bloginfo('description');
}
