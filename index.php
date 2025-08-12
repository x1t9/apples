<?php get_header(); ?>

<main class="site-main">
    <div class="content-area">
        <div class="container">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <?php if (is_single()) : ?>
                                <div class="entry-meta">
                                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                                    <span class="byline"> by <?php the_author(); ?></span>
                                </div>
                            <?php endif; ?>
                        </header>

                        <div class="entry-content">
                            <?php
                            if (is_single() || is_page()) {
                                the_content();
                            } else {
                                the_excerpt();
                            }
                            ?>
                        </div>

                        <?php if (is_single()) : ?>
                            <footer class="entry-footer">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    echo '<div class="cat-links">Categories: ';
                                    foreach ($categories as $category) {
                                        echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a> ';
                                    }
                                    echo '</div>';
                                }
                                
                                $tags = get_the_tags();
                                if (!empty($tags)) {
                                    echo '<div class="tag-links">Tags: ';
                                    foreach ($tags as $tag) {
                                        echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">' . esc_html($tag->name) . '</a> ';
                                    }
                                    echo '</div>';
                                }
                                ?>
                            </footer>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>

                <?php
                // Pagination
                the_posts_pagination(array(
                    'prev_text' => __('Previous', 'apple-theme'),
                    'next_text' => __('Next', 'apple-theme'),
                ));
                ?>

            <?php else : ?>
                <div class="no-posts">
                    <h2><?php _e('Nothing Found', 'apple-theme'); ?></h2>
                    <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'apple-theme'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>