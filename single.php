<?php get_header(); ?>

<main class="site-main">
    <div class="content-area">
        <div class="container">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-meta">
                            <span class="posted-on">
                                <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                            </span>
                            <span class="byline">
                                <?php _e('by', 'apple-theme'); ?> 
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                    <?php the_author(); ?>
                                </a>
                            </span>
                            <?php if (has_category()) : ?>
                                <span class="cat-links">
                                    <?php _e('in', 'apple-theme'); ?> <?php the_category(', '); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                        
                        <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . __('Pages:', 'apple-theme'),
                            'after' => '</div>',
                        ));
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php if (has_tag()) : ?>
                            <div class="tag-links">
                                <strong><?php _e('Tags:', 'apple-theme'); ?></strong>
                                <?php the_tags('', ', ', ''); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-navigation">
                            <?php
                            the_post_navigation(array(
                                'prev_text' => '<span class="nav-subtitle">' . __('Previous:', 'apple-theme') . '</span> <span class="nav-title">%title</span>',
                                'next_text' => '<span class="nav-subtitle">' . __('Next:', 'apple-theme') . '</span> <span class="nav-title">%title</span>',
                            ));
                            ?>
                        </div>
                    </footer>
                </article>

                <?php
                // Author bio
                if (get_the_author_meta('description')) :
                ?>
                    <div class="author-info">
                        <div class="author-avatar">
                            <?php echo get_avatar(get_the_author_meta('user_email'), 80); ?>
                        </div>
                        <div class="author-description">
                            <h3><?php printf(__('About %s', 'apple-theme'), get_the_author()); ?></h3>
                            <p><?php the_author_meta('description'); ?></p>
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                <?php printf(__('View all posts by %s', 'apple-theme'), get_the_author()); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                // Comments
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>