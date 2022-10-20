<footer class="footer">
    <div id="inner-footer" class="wrap">
        <p class="copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
            <?php
            if (has_nav_menu('footerNav')) {
                echo '<nav id="footer-navigation">';
                wp_nav_menu(array(
                    'container' => false,
                    'container_class' => 'menu',
                    'menu' => __('FooterNav', 'jadotheme'),
                    'menu_class' => 'nav footerNav',
                    'theme_location' => 'footerNav',
                    'depth' => 0
                ));
                echo '</nav>';
            }
            get_sidebar();
            ?>
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
<!--<script async src="https://www.google-analytics.com/analytics.js"></script>-->
<!--<script>-->
<!--    window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;-->
<!--    ga("create", "UA-XXX-XXX-XXX", "auto");-->
<!--    ga("set", "anonymizeIp", true);-->
<!--    ga("send", "pageview");-->
<!--</script>-->
<script>
    function toggleClass(element, className) {
        if (!element || !className) {
            return;
        }
        let classString = element.className, nameIndex = classString.indexOf(className);
        if (nameIndex == -1) {
            classString += ' ' + className;
        } else {
            classString = classString.substr(0, nameIndex) + classString.substr(nameIndex + className.length);
        }
        element.className = classString;
    }

    document.getElementById('burger').addEventListener('click', function () {
        toggleClass(document.getElementById('burger'), 'toggledOn');
        toggleClass(document.getElementById('site-navigation'), 'toggledOn');
    });


    const subMenuElements = document.querySelectorAll('li.menu-item-has-children, li.page_item_has_children');
    for (let i = 0; i < subMenuElements.length; i++) {
        subMenuElements.item(i).onmouseover = function () {
            this.classList.add('toggledOn');
        }
        subMenuElements.item(i).onmouseout = function () {
            this.classList.remove('toggledOn');
        }
    }

    const header = document.getElementById('headerfixed');
    const headerheight = header.clientHeight + 30; //additional space to top when header is fixed
    document.getElementById('inner-content').style.paddingTop = headerheight + 'px';

    const body = document.body;
    const menu = document.querySelector(".header");
    const scrollUp = "scrollUp";
    const scrollDown = "scrollDown";
    let lastScroll = 0;

    window.addEventListener("scroll", () => {
        const currentScroll = window.pageYOffset;
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
</script>
</body>
</html>