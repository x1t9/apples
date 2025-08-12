<?php get_header(); ?>

<main class="site-main">
    <div class="content-area">
        <div class="container">
            <div class="error-404">
                <header class="page-header">
                    <h1 class="page-title"><?php _e('Oops! That page can\'t be found.', 'apple-theme'); ?></h1>
                </header>

                <div class="page-content">
                    <p><?php _e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'apple-theme'); ?></p>

                    <?php get_search_form(); ?>

                    <div class="widget-area">
                        <div class="widget">
                            <h3 class="widget-title"><?php _e('Most Used Categories', 'apple-theme'); ?></h3>
                            <ul>
                                <?php
                                wp_list_categories(array(
                                    'orderby' => 'count',
                                    'order' => 'DESC',
                                    'show_count' => 1,
                                    'title_li' => '',
                                    'number' => 10,
                                ));
                                ?>
                            </ul>
                        </div>

                        <div class="widget">
                            <h3 class="widget-title"><?php _e('Recent Posts', 'apple-theme'); ?></h3>
                            <ul>
                                <?php
                                $recent_posts = wp_get_recent_posts(array(
                                    'numberposts' => 5,
                                    'post_status' => 'publish',
                                ));
                                foreach ($recent_posts as $post) :
                                ?>
                                    <li>
                                        <a href="<?php echo get_permalink($post['ID']); ?>">
                                            <?php echo $post['post_title']; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>