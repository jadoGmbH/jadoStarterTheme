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
</script>
<!-- Header scroll detection -->
<!--
<script src='/wp-includes/js/jquery/jquery.js'></script>
<script>
    jQuery(document).ready(function ($) {
        var position = $(window).scrollTop();
        $(window).scroll(function () {
            var scroll = $(window).scrollTop();
            if (scroll > position) {
                $('header.header').removeClass('show');
            } else {
                $('header.header').addClass('show');
            }
            if (scroll < 20) {
                if ($('header.header').hasClass('show')) {
                } else {
                    $('header.header').addClass('show');
                }
            }
            position = scroll;
        });
    });
</script>
-->
</body>
</html>