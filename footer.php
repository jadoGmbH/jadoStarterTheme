<footer id="footer" class="footer">
    <div id="inner-footer" class="wrap">
        <p class="copyright">
            &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> –
            <span class="powered"><a class="jado" href="https://github.com/jadoGmbH/jadoStarterTheme" target="_blank"
                                     rel="noopener noreferrer">jado Starter Theme <span><svg width="100%" height="100%" viewBox="0 0 1280 640"
                                                                                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:2;">
    <g id="jado2023" transform="matrix(1.72707,0,0,1.72707,-463.754,-370.625)">
        <g id="jado-j" transform="matrix(1.01391,0,0,0.997218,-641.818,-49.6408)">
            <path d="M974.112,305.56L974.246,292.614" style="fill:none;stroke:currentColor;stroke-width:43.18px;"/>
        </g>
        <g id="jado-ja" transform="matrix(1.01391,0,0,0.997218,-641.818,89.3592)">
            <path d="M925.015,470.799C952.112,470.799 974.112,448.432 974.112,420.881L974.246,292.614C974.246,265.063 996.246,242.695 1023.34,242.695L1134.24,242.695C1161.34,242.695 1183.34,265.063 1183.34,292.614L1183.34,382.304" style="fill:none;stroke:currentColor;stroke-width:43.18px;"/>
        </g>
        <g id="jado-a" transform="matrix(1.01391,0,0,0.997218,-419.839,1.88983)">
            <path d="M855.758,410.411L855.758,420.881C855.758,448.432 877.757,470.799 904.855,470.799L988.915,470.799" style="fill:none;stroke:currentColor;stroke-width:43.18px;"/>
        </g>
        <g id="jado-do" transform="matrix(1.01391,0,0,0.997218,-5.12305,1.7787)">
            <path d="M855.758,410.411L855.758,420.881C855.758,448.432 877.757,470.799 904.855,470.799L925.015,470.799C952.112,470.799 974.112,448.432 974.112,420.881L974.112,380.328C974.112,352.777 952.112,330.409 925.015,330.409L703.848,330.51C676.751,330.51 654.751,352.878 654.751,380.429L654.751,420.982C654.751,448.533 676.751,470.901 703.848,470.901L724.008,470.901C751.106,470.901 773.105,448.533 773.105,420.982L773.105,240.038" style="fill:none;stroke:currentColor;stroke-width:43.18px;"/>
        </g>
    </g>
</svg></span></a></span>
        </p>
        <?php
        if (get_option('business_show_social_footer')) {
            echo '<div class="socialmediaicons">';
            if ($link = get_option('business_facebook')) {
                echo '<a target="_blank" class="facebook" href="' . esc_url($link) . '" target="_blank" rel="noopener">';
                echo file_get_contents(get_template_directory() . '/lib/img/social-media-icon_facebook.svg');
                echo '</a>';
            }
            if ($link = get_option('business_instagram')) {
                echo '<a target="_blank" class="instagram" href="' . esc_url($link) . '" target="_blank" rel="noopener">';
                echo file_get_contents(get_template_directory() . '/lib/img/social-media-icon_instagram.svg');
                echo '</a>';
            }
            if ($link = get_option('business_linkedIn')) {
                echo '<a target="_blank" class="linkedin" href="' . esc_url($link) . '" target="_blank" rel="noopener">';
                echo file_get_contents(get_template_directory() . '/lib/img/social-media-icon_linkedin.svg');
                echo '</a>';
            }
            if ($link = get_option('business_bluesky')) {
                echo '<a target="_blank" class="bluesky" href="' . esc_url($link) . '" target="_blank" rel="noopener">';
                echo file_get_contents(get_template_directory() . '/lib/img/social-media-icon_bluesky.svg');
                echo '</a>';
            }
            if ($link = get_option('business_mastodon')) {
                echo '<a target="_blank" class="mastodon" href="' . esc_url($link) . '" target="_blank" rel="noopener">';
                echo file_get_contents(get_template_directory() . '/lib/img/social-media-icon_mastodon.svg');
                echo '</a>';
            }
            if ($link = get_option('business_telephone')) {
                $tel_clean = preg_replace('/[^\d+]/', '', $link);
                echo '<a target="_blank" class="telephone" href="tel:' . esc_attr($tel_clean) . '" target="_blank" rel="noopener">';
                echo file_get_contents(get_template_directory() . '/lib/img/social-media-icon_phone.svg');
                echo '</a>';
            }
            if ($link = get_option('business_whatsapp')) {
                $wa_clean = preg_replace('/\D+/', '', $link);
                if (!empty($wa_clean)) {
                    echo '<a target="_blank" class="whatsapp" href="https://wa.me/' . esc_attr($wa_clean) . '" rel="noopener">';
                    echo file_get_contents(get_template_directory() . '/lib/img/social-media-icon_whatsapp.svg');
                    echo '</a>';
                }
            }
            if ($link = get_option('business_email')) {
                $email_clean = sanitize_email($link);
                if (!empty($email_clean)) {
                    echo '<a target="_blank" class="email" href="mailto:' . esc_attr($email_clean) . '" rel="noopener">';
                    echo file_get_contents(get_template_directory() . '/lib/img/social-media-icon_mail.svg');
                    echo '</a>';
                }
            }
            if ($link = get_option('business_googlemaps')) {
                echo '<a target="_blank" class="telephone" href="' . esc_url($link) . '" target="_blank" rel="noopener">';
                echo file_get_contents(get_template_directory() . '/lib/img/social-media-icon_location.svg');
                echo '</a>';
            }
            echo '</div>';
        }
        get_sidebar(); ?>
    </div>
</footer>
</div>
<?php wp_footer();
if (str_contains($_SERVER["HTTP_HOST"], 'local') !== false) {
    echo '<div class="template">';
    global $template;
    echo basename($template);
    echo '</div>';
}
?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        const subMenuElements = document.querySelectorAll('li.menu-item-has-children');
        const header = document.getElementById('fixedHeader');
        const innerContent = document.getElementById('inner-content');
        const burger = document.getElementById('burger');
        const toggleSubMenu = (element) => {
            const currentlyOpenMenus = document.querySelectorAll('.menu-item-has-children.toggledOn');
            currentlyOpenMenus.forEach(menu => {
                if (menu !== element) {
                    menu.classList.remove('toggledOn');
                }
            });
            element.classList.toggle('toggledOn');
        };
        if (!isTouchDevice) {
            subMenuElements.forEach(item => {
                item.addEventListener('mouseover', function () {
                    this.classList.add('toggledOn');
                });

                item.addEventListener('mouseout', function () {
                    this.classList.remove('toggledOn');
                });
            });
        }
        if (isTouchDevice) {
            subMenuElements.forEach(item => {
                item.addEventListener('click', function (e) {
                    if (!this.classList.contains('toggledOn')) {
                        e.preventDefault();
                        toggleSubMenu(this);
                    }
                });
            });
        }
        const siteNavigation = document.getElementById('site-navigation');
        if (burger && siteNavigation) {
            burger.addEventListener('click', function () {
                siteNavigation.classList.toggle('burgerToggledOn');
                burger.classList.toggle('burgerToggledOn');
            });
        }
        document.addEventListener('click', function (event) {
            const isClickInside = siteNavigation.contains(event.target) || burger.contains(event.target);
            if (!isClickInside && isTouchDevice) {
                const openMenus = document.querySelectorAll('.menu-item-has-children.toggledOn');
                openMenus.forEach(menu => menu.classList.remove('toggledOn'));
                siteNavigation.classList.remove('burgerToggledOn');
            }
        });
        if (innerContent && header) {
            innerContent.style.paddingTop = `${header.offsetHeight + 30}px`;
        }
        if (burger && header) {
            burger.style.height = `${header.offsetHeight}px`;
        }
        let lastScroll = 0;
        const scrollUp = "scrollUp";
        const scrollDown = "scrollDown";
        const body = document.body;
        let ticking = false;
        function handleScroll() {
            const currentScroll = window.scrollY;
            const scrollPosition = window.scrollY + window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            if (scrollPosition >= documentHeight - 2) {
                body.classList.remove(scrollDown);
                body.classList.add(scrollUp);
            } else if (currentScroll > lastScroll && !body.classList.contains(scrollDown)) {
                body.classList.remove(scrollUp);
                body.classList.add(scrollDown);
            } else if (currentScroll < lastScroll && !body.classList.contains(scrollUp)) {
                body.classList.remove(scrollDown);
                body.classList.add(scrollUp);
            }
            lastScroll = currentScroll;
            ticking = false;
        }
        window.addEventListener("scroll", () => {
            if (!ticking) {
                window.requestAnimationFrame(handleScroll);
                ticking = true;
            }
        }, {passive: true});
    });
</script>
</body>
</html>
