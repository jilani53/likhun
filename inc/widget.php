<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @package likhun
 */

/**
 * Registers our main widget area and the front page widget areas.
 */

function likhun_widgets_init() {

    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'likhun'),
        'id'            => 'sidebar',
        'description'   => esc_html__('Sidebar position.', 'likhun'),
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
    ));

}
add_action('widgets_init', 'likhun_widgets_init');
