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
        toggleClass(document.getElementById('burger'), 'toggled-on');
        toggleClass(document.getElementById('site-navigation'), 'toggled-on');
    });


    var header = document.getElementById('headerfixed');
    var headerheight = header.clientHeight + 30; //additional space to top
    document.getElementById('inner-content').style.paddingTop = headerheight + 'px';

    window.addEventListener('wheel', checkScrollDirection);

    function add_class_on_scroll() {
        header.classList.add('show');
    }
    function remove_class_on_scroll() {
        header.classList.remove('show');
    }
    function checkScrollDirection(event) {
        if (checkScrollDirectionIsUp(event)) {
            add_class_on_scroll();
        } else {
            remove_class_on_scroll();
        }
    }
    function checkScrollDirectionIsUp(event) {
        if (event.deltaY) {
            return event.deltaY < 0;
        }
        return event.deltaY > 0;
    }
</script>
</body>
</html>