<?php
/**
 * Apple Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function apple_theme_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    
    // Add Elementor support
    add_theme_support('elementor');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'apple-theme'),
        'footer' => __('Footer Menu', 'apple-theme'),
    ));
    
    // Set content width
    if (!isset($content_width)) {
        $content_width = 800;
    }
}
add_action('after_setup_theme', 'apple_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function apple_theme_scripts() {
    // Main stylesheet
    wp_enqueue_style('apple-theme-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Font files
    wp_enqueue_style('apple-fonts', get_template_directory_uri() . '/asset/fonts', array(), '1.0.0');
    wp_enqueue_style('apple-fonts-mono', get_template_directory_uri() . '/asset/fonts(1)', array(), '1.0.0');
    wp_enqueue_style('apple-fonts-icons', get_template_directory_uri() . '/asset/fonts(2)', array(), '1.0.0');
    
    // Dark mode support
    wp_enqueue_style('apple-dark-mode', get_template_directory_uri() . '/asset/dark-mode.css', array('apple-theme-style'), '1.0.0');
    
    // JavaScript
    wp_enqueue_script('apple-theme-script', get_template_directory_uri() . '/js/theme.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('apple-theme-script', 'apple_theme_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('apple_theme_nonce'),
    ));
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'apple_theme_scripts');

/**
 * Register Widget Areas
 */
function apple_theme_widgets_init() {
    // Footer widget areas
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name' => sprintf(__('Footer %d', 'apple-theme'), $i),
            'id' => "footer-$i",
            'description' => sprintf(__('Footer widget area %d', 'apple-theme'), $i),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
    }
    
    // Sidebar
    register_sidebar(array(
        'name' => __('Sidebar', 'apple-theme'),
        'id' => 'sidebar-1',
        'description' => __('Main sidebar widget area', 'apple-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'apple_theme_widgets_init');

/**
 * Fallback menu for primary navigation
 */
function apple_theme_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'apple-theme') . '</a></li>';
    
    $pages = get_pages(array('sort_column' => 'menu_order'));
    foreach ($pages as $page) {
        echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
    }
    
    echo '</ul>';
}

/**
 * Customizer Settings
 */
function apple_theme_customize_register($wp_customize) {
    // Theme Options Panel
    $wp_customize->add_panel('apple_theme_options', array(
        'title' => __('Apple Theme Options', 'apple-theme'),
        'priority' => 30,
    ));
    
    // Typography Section
    $wp_customize->add_section('apple_typography', array(
        'title' => __('Typography', 'apple-theme'),
        'panel' => 'apple_theme_options',
    ));
    
    // Font Family Setting
    $wp_customize->add_setting('apple_font_family', array(
        'default' => 'sf-pro',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('apple_font_family', array(
        'label' => __('Font Family', 'apple-theme'),
        'section' => 'apple_typography',
        'type' => 'select',
        'choices' => array(
            'sf-pro' => 'SF Pro (Default)',
            'helvetica' => 'Helvetica Neue',
            'arial' => 'Arial',
            'system' => 'System Font',
        ),
    ));
    
    // Header Section
    $wp_customize->add_section('apple_header', array(
        'title' => __('Header Options', 'apple-theme'),
        'panel' => 'apple_theme_options',
    ));
    
    // Header Background Opacity
    $wp_customize->add_setting('header_bg_opacity', array(
        'default' => 0.8,
        'sanitize_callback' => 'apple_theme_sanitize_float',
    ));
    
    $wp_customize->add_control('header_bg_opacity', array(
        'label' => __('Header Background Opacity', 'apple-theme'),
        'section' => 'apple_header',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 0,
            'max' => 1,
            'step' => 0.1,
        ),
    ));
    
    // Colors Section
    $wp_customize->add_section('apple_colors', array(
        'title' => __('Colors', 'apple-theme'),
        'panel' => 'apple_theme_options',
    ));
    
    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default' => '#0071e3',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => __('Primary Color', 'apple-theme'),
        'section' => 'apple_colors',
    )));
    
    // Secondary Color
    $wp_customize->add_setting('secondary_color', array(
        'default' => '#1d1d1f',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label' => __('Secondary Color', 'apple-theme'),
        'section' => 'apple_colors',
    )));
}
add_action('customize_register', 'apple_theme_customize_register');

/**
 * Sanitize float values
 */
function apple_theme_sanitize_float($input) {
    return floatval($input);
}

/**
 * Output custom CSS based on customizer settings
 */
function apple_theme_custom_css() {
    $font_family = get_theme_mod('apple_font_family', 'sf-pro');
    $header_opacity = get_theme_mod('header_bg_opacity', 0.8);
    $primary_color = get_theme_mod('primary_color', '#0071e3');
    $secondary_color = get_theme_mod('secondary_color', '#1d1d1f');
    
    $css = '<style type="text/css">';
    
    // Font family
    if ($font_family !== 'sf-pro') {
        $font_stack = '';
        switch ($font_family) {
            case 'helvetica':
                $font_stack = '"Helvetica Neue", "Helvetica", "Arial", sans-serif';
                break;
            case 'arial':
                $font_stack = '"Arial", sans-serif';
                break;
            case 'system':
                $font_stack = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
                break;
        }
        
        if ($font_stack) {
            $css .= "body { font-family: $font_stack; }";
        }
    }
    
    // Header opacity
    $css .= ".site-header { background-color: rgba(0, 0, 0, $header_opacity); }";
    
    // Colors
    $css .= ":root { --primary-color: $primary_color; --secondary-color: $secondary_color; }";
    $css .= ".btn { background-color: $primary_color; }";
    $css .= ".btn:hover { background-color: " . apple_theme_adjust_brightness($primary_color, -20) . "; }";
    
    $css .= '</style>';
    
    echo $css;
}
add_action('wp_head', 'apple_theme_custom_css');

/**
 * Adjust color brightness
 */
function apple_theme_adjust_brightness($hex, $steps) {
    $steps = max(-255, min(255, $steps));
    $hex = str_replace('#', '', $hex);
    
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }
    
    $color_parts = str_split($hex, 2);
    $return = '#';
    
    foreach ($color_parts as $color) {
        $color = hexdec($color);
        $color = max(0, min(255, $color + $steps));
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT);
    }
    
    return $return;
}

/**
 * Add Elementor support
 */
function apple_theme_elementor_support() {
    // Remove Elementor's default fonts
    add_filter('elementor/fonts/groups', '__return_empty_array');
    
    // Add theme fonts to Elementor
    add_filter('elementor/fonts/additional_fonts', function($fonts) {
        $fonts['SF Pro Display'] = 'system';
        $fonts['SF Pro Text'] = 'system';
        return $fonts;
    });
}
add_action('after_setup_theme', 'apple_theme_elementor_support');

/**
 * Optimize performance
 */
function apple_theme_optimize_performance() {
    // Remove unnecessary WordPress features
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Disable embeds
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('init', 'apple_theme_optimize_performance');

/**
 * Add preload for critical resources
 */
function apple_theme_preload_resources() {
    echo '<link rel="preload" href="' . get_template_directory_uri() . '/asset/fonts" as="style">';
    echo '<link rel="preload" href="' . get_stylesheet_uri() . '" as="style">';
}
add_action('wp_head', 'apple_theme_preload_resources', 1);

/**
 * Add theme support for Gutenberg
 */
function apple_theme_gutenberg_support() {
    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for wide and full alignment
    add_theme_support('align-wide');
    
    // Add custom color palette
    add_theme_support('editor-color-palette', array(
        array(
            'name' => __('Primary Blue', 'apple-theme'),
            'slug' => 'primary-blue',
            'color' => '#0071e3',
        ),
        array(
            'name' => __('Dark Gray', 'apple-theme'),
            'slug' => 'dark-gray',
            'color' => '#1d1d1f',
        ),
        array(
            'name' => __('Light Gray', 'apple-theme'),
            'slug' => 'light-gray',
            'color' => '#f5f5f7',
        ),
    ));
}
add_action('after_setup_theme', 'apple_theme_gutenberg_support');