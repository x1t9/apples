<?php get_header(); ?>

<main class="site-main">
    <div class="content-area">
        <div class="container">
            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    printf(
                        __('Search Results for: %s', 'apple-theme'),
                        '<span>' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
            </header>

            <?php if (have_posts()) : ?>
                <div class="search-results">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('search-result'); ?>>
                            <header class="entry-header">
                                <h2 class="entry-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="entry-meta">
                                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                                    <span class="post-type"><?php echo get_post_type(); ?></span>
                                </div>
                            </header>

                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                the_posts_pagination(array(
                    'prev_text' => __('Previous', 'apple-theme'),
                    'next_text' => __('Next', 'apple-theme'),
                ));
                ?>

            <?php else : ?>
                <div class="no-results">
                    <h2><?php _e('Nothing Found', 'apple-theme'); ?></h2>
                    <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'apple-theme'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>