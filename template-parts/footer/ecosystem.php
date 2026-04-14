<?php
/**
 * Footer ecosystem: Brand logos strip
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$logos = array();
for ( $i = 1; $i <= 8; $i++ ) {
    $url = get_theme_mod( "flavor_ecosystem_logo_{$i}", '' );
    if ( $url ) {
        $logos[] = $url;
    }
}

if ( empty( $logos ) ) {
    return;
}
?>

<div class="border-t border-gray-600">
    <div class="container-site">
        <div class="overflow-x-auto flex gap-6 py-4 items-center">
            <?php foreach ( $logos as $logo ) : ?>
                <img
                    src="<?php echo esc_url( $logo ); ?>"
                    alt=""
                    class="h-8 w-auto shrink-0 opacity-60 hover:opacity-100 transition-opacity brightness-0 invert"
                    loading="lazy"
                >
            <?php endforeach; ?>
        </div>
    </div>
</div>
