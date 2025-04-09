<footer id="footer" class="footer">
    <div id="inner-footer" class="wrap">
        <p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> – <a href="https://github.com/jadoGmbH/jadoStarterTheme" target="_blank">Powered by jado Starter Theme</a></p>
            <?php get_sidebar(); ?>
    </div>
</footer>
</div>
<?php wp_footer();
/*
if (str_contains($_SERVER["HTTP_HOST"], 'local') !== false) {
    echo '<div class="template">';
    global $template;
    echo basename($template);
    echo '</div>';
}
*/
?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        const subMenuElements = document.querySelectorAll('li.menu-item-has-children');
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
        const burger = document.getElementById('burger');
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



        const header = document.getElementById('header');
        const burgerheight = header.clientHeight;
        const headerheight = header.clientHeight + 30; //additional space to top when header is fixed
        document.getElementById('inner-content').style.paddingTop = headerheight + 'px';
        burger.style.height = burgerheight + 'px';
        const body = document.body;
        const menu = document.querySelector(".header");
        const scrollUp = "scrollUp";
        const scrollDown = "scrollDown";
        let lastScroll = 0;
        window.addEventListener("scroll", () => {
            const currentScroll = window.scrollY;
            if (currentScroll <= 0) {
                body.classList.remove(scrollUp);
                return;
            }
            if (currentScroll > lastScroll && !body.classList.contains(scrollDown)) {
                body.classList.remove(scrollUp);
                body.classList.add(scrollDown);
            } else if (
                currentScroll < lastScroll &&
                body.classList.contains(scrollDown)
            ) {
                body.classList.remove(scrollDown);
                body.classList.add(scrollUp);
            }
            lastScroll = currentScroll;
        });
    });


</script>
</body>
</html>