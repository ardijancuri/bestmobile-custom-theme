<?php
/**
 * Top Bar - Announcement/Promo Bar
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$topbar_enabled        = get_theme_mod( 'flavor_topbar_enabled', true );
$is_customizer_preview = is_customize_preview();

if ( ! $topbar_enabled ) {
	return;
}

$topbar_text       = get_theme_mod( 'flavor_topbar_text', esc_html__( 'Free shipping on orders over €50', 'flavor' ) );
$topbar_bg_color   = sanitize_hex_color( get_theme_mod( 'flavor_topbar_bg_color', '#1A1A1A' ) ) ?: '#1A1A1A';
$topbar_text_color = sanitize_hex_color( get_theme_mod( 'flavor_topbar_text_color', '#FFFFFF' ) ) ?: '#FFFFFF';
?>

<div
    x-data="{
        preview: <?php echo $is_customizer_preview ? 'true' : 'false'; ?>,
        show: <?php echo $is_customizer_preview ? 'true' : '!localStorage.getItem(\'topbar_dismissed\')'; ?>,
        scrolled: false
    }"
    x-init="if (!preview) { window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 }, { passive: true }); }"
    x-show="show"
    class="relative z-40 overflow-hidden text-xs transition-all duration-300 max-h-12 opacity-100"
    :class="preview || !scrolled ? 'max-h-12 opacity-100' : 'max-h-0 opacity-0'"
    style="background-color: <?php echo esc_attr( $topbar_bg_color ); ?>; color: <?php echo esc_attr( $topbar_text_color ); ?>;"
>
    <div class="container-site flex items-center justify-start px-4 py-2 tablet-sm:justify-center">
        <svg class="mr-2 h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
        </svg>

        <span><?php echo esc_html( $topbar_text ); ?></span>

        <button
            @click="if (!preview) { show = false; localStorage.setItem('topbar_dismissed', '1'); }"
            class="absolute right-3 top-1/2 -translate-y-1/2 p-1 transition-opacity hover:opacity-70"
            aria-label="<?php esc_attr_e( 'Dismiss announcement', 'flavor' ); ?>"
        >
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
