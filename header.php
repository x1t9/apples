<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-content">
        <div class="site-logo">
            <?php
            $custom_logo_id = get_theme_mod('custom_logo');
            if ($custom_logo_id) {
                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                echo '<a href="' . esc_url(home_url('/')) . '"><img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '"></a>';
            } else {
                echo '<a href="' . esc_url(home_url('/')) . '" class="logo-placeholder">' . get_bloginfo('name') . '</a>';
            }
            ?>
        </div>

        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'nav-menu',
                'container' => false,
                'fallback_cb' => 'apple_theme_fallback_menu',
            ));
            ?>
        </nav>

        <div class="header-actions">
            <button class="search-toggle" aria-label="<?php _e('Search', 'apple-theme'); ?>">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                    <path d="M15.25,28.28l-3.9-3.9a6,6,0,1,0-.86.87l3.9,3.9a.6.6,0,0,0,.86,0,.62.62,0,0,0,0-.87ZM1.86,20.57a4.81,4.81,0,1,1,4.81,4.81A4.81,4.81,0,0,1,1.86,20.57Z" transform="translate(-0.5 -14)"/>
                </svg>
            </button>
            
            <button class="mobile-menu-toggle" aria-label="<?php _e('Menu', 'apple-theme'); ?>">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                    <path d="M2 4h14v1H2V4zm0 4.5h14v1H2v-1zM2 13h14v1H2v-1z"/>
                </svg>
            </button>
        </div>
    </div>
</header>

<div id="page" class="site">