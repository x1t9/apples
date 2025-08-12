<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?php _e('Search for:', 'apple-theme'); ?></span>
        <input type="search" class="search-field" placeholder="<?php _e('Search...', 'apple-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    </label>
    <button type="submit" class="search-submit">
        <span class="screen-reader-text"><?php _e('Search', 'apple-theme'); ?></span>
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
            <path d="M15.25,28.28l-3.9-3.9a6,6,0,1,0-.86.87l3.9,3.9a.6.6,0,0,0,.86,0,.62.62,0,0,0,0-.87ZM1.86,20.57a4.81,4.81,0,1,1,4.81,4.81A4.81,4.81,0,0,1,1.86,20.57Z" transform="translate(-0.5 -14)"/>
        </svg>
    </button>
</form>