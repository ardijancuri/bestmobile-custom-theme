<?php
/**
 * Footer template
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;
?>

<footer class="site-footer bg-black-dark text-white mt-auto">
    <div class="site-footer-inner container-site py-8 md:py-10">
        <div class="grid grid-cols-1 tablet-sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <?php get_template_part( 'template-parts/footer/column', 'brand' ); ?>
            <?php get_template_part( 'template-parts/footer/column', 'account' ); ?>
            <?php get_template_part( 'template-parts/footer/column', 'faq' ); ?>
            <?php get_template_part( 'template-parts/footer/column', 'contact' ); ?>
        </div>
    </div>

    <?php get_template_part( 'template-parts/footer/ecosystem' ); ?>

    <div class="py-4 text-center text-xs text-white">
        &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
        <?php esc_html_e( 'Powered by', 'flavor' ); ?>
        <a href="https://oninova.net" target="_blank" rel="noopener noreferrer" class="underline hover:no-underline">Oninova</a>
    </div>
</footer>

<?php get_template_part( 'template-parts/global/bottom-nav' ); ?>
<?php get_template_part( 'template-parts/global/cookie-consent' ); ?>
<?php get_template_part( 'template-parts/global/toast-notifications' ); ?>
<?php get_template_part( 'template-parts/global/scroll-to-top' ); ?>

<?php wp_footer(); ?>
<script>
(function(){
  var nav = document.querySelector('nav[aria-label]');
  if(!nav || window.innerWidth >= 1024) return;
  if(window.visualViewport){
    function pin(){
      nav.style.bottom = (window.innerHeight - window.visualViewport.height - window.visualViewport.offsetTop) + 'px';
    }
    window.visualViewport.addEventListener('resize', pin);
    window.visualViewport.addEventListener('scroll', pin);
  }
})();
</script>
</body>
</html>
