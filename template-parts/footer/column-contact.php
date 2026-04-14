<?php
/**
 * Footer column: Contact
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$email          = get_theme_mod( 'flavor_contact_email', 'info@example.com' );
$phone          = get_theme_mod( 'flavor_contact_phone', '' );
$whatsapp       = get_theme_mod( 'flavor_whatsapp_number', '' );
$viber          = get_theme_mod( 'flavor_viber_number', '' );
$business_email = get_theme_mod( 'flavor_business_email', '' );
$address        = get_theme_mod( 'flavor_address', '' );
?>

<div x-data="{ open: false }">
    <h4
        class="text-sm font-semibold uppercase tracking-wider mb-3 md:mb-4 cursor-pointer flex items-center justify-between lg:cursor-default"
        @click="open = !open"
    >
        <?php esc_html_e( 'Contact', 'flavor' ); ?>
        <svg class="w-4 h-4 lg:hidden transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </h4>

    <div class="mb-4 md:mb-0 space-y-2 md:space-y-3 text-sm text-gray-400 lg:!block" x-show="open" x-cloak x-transition>
        <!-- Email -->
        <?php if ( $email ) : ?>
            <a href="mailto:<?php echo esc_attr( $email ); ?>" class="flex items-center gap-2 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <?php echo esc_html( $email ); ?>
            </a>
        <?php endif; ?>

        <!-- Phone -->
        <?php if ( $phone ) : ?>
            <a href="tel:<?php echo esc_attr( $phone ); ?>" class="flex items-center gap-2 hover:text-green-400 transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <?php echo esc_html( $phone ); ?>
            </a>
        <?php endif; ?>

        <!-- WhatsApp & Viber -->
        <div class="flex items-center gap-3 md:gap-4">
            <?php if ( $whatsapp ) : ?>
                <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $whatsapp ) ); ?>" target="_blank" rel="noopener noreferrer" class="relative group" aria-label="WhatsApp" title="<?php echo esc_attr( $whatsapp ); ?>">
                    <svg class="w-6 h-6 text-gray-400 hover:text-green-500 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs bg-gray-800 text-white rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none"><?php echo esc_html( $whatsapp ); ?></span>
                </a>
            <?php endif; ?>

            <?php if ( $viber ) : ?>
                <a href="viber://chat?number=<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $viber ) ); ?>" class="relative group" aria-label="Viber" title="<?php echo esc_attr( $viber ); ?>">
                    <svg class="w-6 h-6 text-gray-400 hover:text-purple-500 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M11.398.002C9.473.028 5.331.344 3.014 2.467 1.294 4.177.518 6.769.399 9.932c-.12 3.163-.27 9.09 5.566 10.728l.007.001-.004 2.458s-.038.993.617 1.196c.793.245 1.258-.51 2.014-1.325.415-.448.988-1.106 1.42-1.608 3.913.331 6.92-.423 7.265-.537.795-.263 5.29-.833 6.024-6.804.758-6.163-.355-10.06-2.329-11.828C19.381.95 15.366-.058 11.398.002zm.297 1.931c3.467-.042 6.903.794 8.328 2.078 1.636 1.467 2.58 4.878 1.924 10.209-.6 4.876-4.17 5.263-4.848 5.487-.278.092-2.908.748-6.264.537 0 0-2.484 2.997-3.26 3.782-.122.124-.266.177-.362.152-.134-.035-.171-.196-.17-.432l.025-4.13c-4.8-1.34-4.52-6.207-4.42-8.836.1-2.629.735-4.852 2.172-6.272 1.81-1.753 5.417-2.534 6.875-2.575zM11.934 5.1a.535.535 0 00-.004 1.07c1.658.013 3.088.592 4.181 1.658.526.512 1.58 1.879 1.648 3.832a.535.535 0 101.07-.034c-.084-2.395-1.375-3.985-1.982-4.576C15.612 5.81 13.916 5.112 11.934 5.1zm-3.462.677c-.3-.005-.587.143-.824.412l-.007.007c-.587.627-.894 1.2-.963 1.767-.03.246-.019.487.035.72l.01.032c.335 1.284.947 2.477 1.7 3.606a15.04 15.04 0 003.455 3.637l.03.024c.545.42 1.114.79 1.72 1.1l.025.012c.508.258 1.108.456 1.684.303.59-.156 1.104-.574 1.622-1.159a.907.907 0 00.107-1.003c-.453-.838-.97-1.637-1.565-2.378a.875.875 0 00-1.06-.232l-.892.567c-.12.077-.268.074-.371-.009-.688-.548-1.294-1.17-1.793-1.88-.098-.125-.097-.298.01-.41l.5-.784a.875.875 0 00.028-1.06 13.455 13.455 0 00-1.94-2.38.825.825 0 00-.511-.29.79.79 0 00-.001 0zm3.57 1.268a.535.535 0 00-.019 1.07c.889.016 1.586.348 2.14.968.29.323.507.722.637 1.165a.535.535 0 001.029-.299 4.176 4.176 0 00-.862-1.58c-.744-.833-1.728-1.301-2.908-1.323a.535.535 0 00-.018 0zm.08 2.092a.535.535 0 00-.004 1.07c.622.006.903.397 1.003.89a.535.535 0 101.048-.216c-.173-.842-.748-1.75-2.034-1.744a.535.535 0 00-.013 0z"/></svg>
                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs bg-gray-800 text-white rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none"><?php echo esc_html( $viber ); ?></span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Business email -->
        <?php if ( $business_email ) : ?>
            <a href="mailto:<?php echo esc_attr( $business_email ); ?>" class="flex items-center gap-2 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <?php echo esc_html( $business_email ); ?>
            </a>
        <?php endif; ?>

        <!-- Address -->
        <?php if ( $address ) : ?>
            <div class="flex items-start gap-2">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span><?php echo esc_html( $address ); ?></span>
            </div>
        <?php endif; ?>
    </div>
</div>
