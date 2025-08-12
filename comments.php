<?php
/**
 * The template for displaying comments
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    _x('One thought on &ldquo;%1$s&rdquo;', 'comments title', 'apple-theme'),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    _nx(
                        '%1$s thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        $comment_count,
                        'comments title',
                        'apple-theme'
                    ),
                    number_format_i18n($comment_count),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h3>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
                'callback' => 'apple_theme_comment',
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation(array(
            'prev_text' => __('Older Comments', 'apple-theme'),
            'next_text' => __('Newer Comments', 'apple-theme'),
        ));
        ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php _e('Comments are closed.', 'apple-theme'); ?></p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply' => __('Leave a Reply', 'apple-theme'),
        'title_reply_to' => __('Leave a Reply to %s', 'apple-theme'),
        'cancel_reply_link' => __('Cancel Reply', 'apple-theme'),
        'label_submit' => __('Post Comment', 'apple-theme'),
        'class_submit' => 'btn',
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun', 'apple-theme') . '</label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>',
    ));
    ?>
</div>

<?php
/**
 * Custom comment callback
 */
function apple_theme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <article class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar($comment, 50); ?>
                    <b class="fn"><?php comment_author_link(); ?></b>
                    <span class="says"><?php _e('says:', 'apple-theme'); ?></span>
                </div>

                <div class="comment-metadata">
                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                        <time datetime="<?php comment_time('c'); ?>">
                            <?php printf(_x('%1$s at %2$s', '1: date, 2: time', 'apple-theme'), get_comment_date(), get_comment_time()); ?>
                        </time>
                    </a>
                    <?php edit_comment_link(__('Edit', 'apple-theme'), '<span class="edit-link">', '</span>'); ?>
                </div>

                <?php if ('0' == $comment->comment_approved) : ?>
                    <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'apple-theme'); ?></p>
                <?php endif; ?>
            </footer>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <div class="reply">
                <?php
                comment_reply_link(array_merge($args, array(
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                )));
                ?>
            </div>
        </article>
    <?php
}
?>