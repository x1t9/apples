/**
 * Apple Theme JavaScript
 */

(function($) {
    'use strict';
    
    // DOM Ready
    $(document).ready(function() {
        initMobileMenu();
        initSmoothScroll();
        initHeaderScroll();
        initSearchToggle();
        initAnimations();
    });
    
    /**
     * Initialize mobile menu
     */
    function initMobileMenu() {
        const $mobileToggle = $('.mobile-menu-toggle');
        const $navMenu = $('.nav-menu');
        
        $mobileToggle.on('click', function() {
            $navMenu.toggleClass('active');
            $(this).attr('aria-expanded', $navMenu.hasClass('active'));
            
            // Toggle hamburger animation
            $(this).toggleClass('active');
        });
        
        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .mobile-menu-toggle').length) {
                $navMenu.removeClass('active');
                $mobileToggle.removeClass('active').attr('aria-expanded', 'false');
            }
        });
        
        // Close menu on escape key
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27 && $navMenu.hasClass('active')) {
                $navMenu.removeClass('active');
                $mobileToggle.removeClass('active').attr('aria-expanded', 'false');
            }
        });
    }
    
    /**
     * Initialize smooth scrolling
     */
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                const target = $(this.hash);
                const $target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if ($target.length) {
                    $('html, body').animate({
                        scrollTop: $target.offset().top - 60
                    }, 800, 'easeInOutCubic');
                    return false;
                }
            }
        });
    }
    
    /**
     * Initialize header scroll behavior
     */
    function initHeaderScroll() {
        let lastScrollTop = 0;
        const $header = $('.site-header');
        const headerHeight = $header.outerHeight();
        
        $(window).on('scroll', throttle(function() {
            const scrollTop = $(window).scrollTop();
            
            // Add/remove scrolled class
            if (scrollTop > 10) {
                $header.addClass('scrolled');
            } else {
                $header.removeClass('scrolled');
            }
            
            // Hide/show header on scroll
            if (scrollTop > lastScrollTop && scrollTop > headerHeight) {
                $header.addClass('header-hidden');
            } else {
                $header.removeClass('header-hidden');
            }
            
            lastScrollTop = scrollTop;
        }, 100));
    }
    
    /**
     * Initialize search toggle
     */
    function initSearchToggle() {
        const $searchToggle = $('.search-toggle');
        
        $searchToggle.on('click', function() {
            // Create search overlay if it doesn't exist
            if (!$('.search-overlay').length) {
                createSearchOverlay();
            }
            
            $('.search-overlay').addClass('active');
            $('.search-overlay input').focus();
        });
        
        // Close search on escape
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27) {
                $('.search-overlay').removeClass('active');
            }
        });
    }
    
    /**
     * Create search overlay
     */
    function createSearchOverlay() {
        const searchOverlay = `
            <div class="search-overlay">
                <div class="search-container">
                    <form role="search" method="get" action="${apple_theme_ajax.home_url}">
                        <input type="search" placeholder="Search..." name="s" autocomplete="off">
                        <button type="submit" aria-label="Search">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M15.25,28.28l-3.9-3.9a6,6,0,1,0-.86.87l3.9,3.9a.6.6,0,0,0,.86,0,.62.62,0,0,0,0-.87ZM1.86,20.57a4.81,4.81,0,1,1,4.81,4.81A4.81,4.81,0,0,1,1.86,20.57Z" transform="translate(-0.5 -14)"/>
                            </svg>
                        </button>
                    </form>
                    <button class="search-close" aria-label="Close search">×</button>
                </div>
            </div>
        `;
        
        $('body').append(searchOverlay);
        
        // Close search overlay
        $('.search-close, .search-overlay').on('click', function(e) {
            if (e.target === this) {
                $('.search-overlay').removeClass('active');
            }
        });
    }
    
    /**
     * Initialize animations
     */
    function initAnimations() {
        // Fade in elements on scroll
        const $animatedElements = $('.fade-in');
        
        if ($animatedElements.length) {
            $(window).on('scroll', throttle(function() {
                $animatedElements.each(function() {
                    const $element = $(this);
                    const elementTop = $element.offset().top;
                    const elementBottom = elementTop + $element.outerHeight();
                    const viewportTop = $(window).scrollTop();
                    const viewportBottom = viewportTop + $(window).height();
                    
                    if (elementBottom > viewportTop && elementTop < viewportBottom) {
                        $element.addClass('animated');
                    }
                });
            }, 100));
        }
    }
    
    /**
     * Throttle function
     */
    function throttle(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    /**
     * Debounce function
     */
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                if (!immediate) func(...args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func(...args);
        };
    }
    
    // Window load
    $(window).on('load', function() {
        // Remove loading class if present
        $('body').removeClass('loading');
        
        // Initialize any load-dependent features
        initLazyLoading();
    });
    
    /**
     * Initialize lazy loading for images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }
    
})(jQuery);

// Vanilla JS for critical functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add loaded class to body
    document.body.classList.add('loaded');
    
    // Initialize critical performance features
    initCriticalCSS();
    initServiceWorker();
});

/**
 * Initialize critical CSS loading
 */
function initCriticalCSS() {
    // Load non-critical CSS asynchronously
    const nonCriticalCSS = [
        '/asset/dark-mode.css'
    ];
    
    nonCriticalCSS.forEach(href => {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = href;
        link.media = 'print';
        link.onload = function() {
            this.media = 'all';
        };
        document.head.appendChild(link);
    });
}

/**
 * Initialize service worker for caching
 */
function initServiceWorker() {
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('SW registered: ', registration);
                })
                .catch(function(registrationError) {
                    console.log('SW registration failed: ', registrationError);
                });
        });
    }
}