<footer class="site-footer">
        <div class="footer-content">
            <div class="footer-links">
                <?php
                // Footer Menu Areas
                for ($i = 1; $i <= 4; $i++) {
                    if (is_active_sidebar("footer-$i")) {
                        echo '<div class="footer-section">';
                        dynamic_sidebar("footer-$i");
                        echo '</div>';
                    }
                }
                ?>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'apple-theme'); ?></p>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class' => 'footer-menu',
                    'container' => false,
                    'depth' => 1,
                ));
                ?>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            this.setAttribute('aria-expanded', navMenu.classList.contains('active'));
        });
    }
    
    // Search toggle functionality
    const searchToggle = document.querySelector('.search-toggle');
    if (searchToggle) {
        searchToggle.addEventListener('click', function() {
            // Add your search functionality here
            console.log('Search clicked');
        });
    }
    
    // Smooth header transition on scroll
    let lastScrollTop = 0;
    const header = document.querySelector('.site-header');
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            header.style.transform = 'translateY(-100%)';
        } else {
            header.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
    });
});
</script>

</body>
</html>