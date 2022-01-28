<footer class="footer">
    <div id="inner-footer" class="wrap">
        <p class="copyright">&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?></p>
        <nav id="footer-navigation">
            <?php wp_nav_menu(array(
                'container' => false,
                'container_class' => 'menu',
                'menu' => __('FooterMenu', 'jado'),
                'menu_class' => 'nav footer-nav',
                'theme_location' => 'FooterMenu',
                'depth' => 0
            )); ?>
        </nav>
    </div>
</footer>
</div>
<?php wp_footer();
if  (strpos($_SERVER["HTTP_HOST"], 'local') !== false) {
    echo '<div class="template">';
    global $template;
    echo basename($template);
    echo '</div>';
}
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
        var classString = element.className, nameIndex = classString.indexOf(className);
        if (nameIndex == -1) {
            classString += ' ' + className;
        }
        else {
            classString = classString.substr(0, nameIndex) + classString.substr(nameIndex + className.length);
        }
        element.className = classString;
    }
    document.getElementById('burger').addEventListener('click', function () {
        toggleClass(document.getElementById('burger'), 'toggledOn');
        toggleClass(document.getElementById('site-navigation'), 'toggledOn');
    });

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