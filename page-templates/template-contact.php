<?php
/**
 * Template Name: Contact
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$phone     = get_theme_mod( 'flavor_contact_phone', '+383 44 123 456' );
$email     = get_theme_mod( 'flavor_contact_email', 'info@flavor.com' );
$whatsapp  = get_theme_mod( 'flavor_contact_whatsapp', '' );
$viber     = get_theme_mod( 'flavor_contact_viber', '' );
$address   = get_theme_mod( 'flavor_contact_address', '' );
$hours     = get_theme_mod( 'flavor_contact_hours', __( 'Mon-Fri: 09:00 - 18:00', 'flavor' ) );
$facebook  = get_theme_mod( 'flavor_social_facebook', '' );
$instagram = get_theme_mod( 'flavor_social_instagram', '' );
?>

<div class="max-w-site-xxl mx-auto px-3 md:px-4 py-6">

	<?php get_template_part( 'template-parts/global/breadcrumbs' ); ?>

	<h1 class="text-xl md:text-2xl font-bold text-gray-700 mb-6"><?php esc_html_e( 'Contact Us', 'flavor' ); ?></h1>

	<div class="lg:grid lg:grid-cols-3 lg:gap-8">

		<!-- Contact Form (Left 2/3) -->
		<div class="lg:col-span-2 mb-8 lg:mb-0">
			<div class="border border-gray-200 rounded-xl p-6">
				<h2 class="text-lg font-bold text-gray-700 mb-4"><?php esc_html_e( 'Send us a message', 'flavor' ); ?></h2>

				<form method="post" action="" class="space-y-4" x-data="{ sending: false, sent: false }" @submit.prevent="sending = true; $el.submit()">
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
							<label for="contact-name" class="block text-xs font-medium text-gray-600 mb-1"><?php esc_html_e( 'Your Name', 'flavor' ); ?> <span class="text-red">*</span></label>
							<input type="text" id="contact-name" name="contact_name" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
						</div>
						<div>
							<label for="contact-email" class="block text-xs font-medium text-gray-600 mb-1"><?php esc_html_e( 'Email Address', 'flavor' ); ?> <span class="text-red">*</span></label>
							<input type="email" id="contact-email" name="contact_email" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
						</div>
					</div>

					<div>
						<label for="contact-subject" class="block text-xs font-medium text-gray-600 mb-1"><?php esc_html_e( 'Subject', 'flavor' ); ?> <span class="text-red">*</span></label>
						<input type="text" id="contact-subject" name="contact_subject" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
					</div>

					<div>
						<label for="contact-message" class="block text-xs font-medium text-gray-600 mb-1"><?php esc_html_e( 'Message', 'flavor' ); ?> <span class="text-red">*</span></label>
						<textarea id="contact-message" name="contact_message" rows="5" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
					</div>

					<?php wp_nonce_field( 'flavor_contact_form', 'flavor_contact_nonce' ); ?>

					<button type="submit" class="bg-primary hover:bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-2" :disabled="sending">
						<svg x-show="!sending" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
						<svg x-show="sending" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
						<?php esc_html_e( 'Send Message', 'flavor' ); ?>
					</button>
				</form>
			</div>
		</div>

		<!-- Contact Sidebar (Right 1/3) -->
		<div class="lg:col-span-1">
			<div class="bg-gray-50 rounded-xl p-5 space-y-5 lg:sticky lg:top-24">
				<h2 class="text-lg font-bold text-gray-700"><?php esc_html_e( 'Get in Touch', 'flavor' ); ?></h2>

				<?php if ( $phone ) : ?>
					<div class="flex items-start gap-3">
						<svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
						<div>
							<p class="text-xs font-medium text-gray-500"><?php esc_html_e( 'Phone', 'flavor' ); ?></p>
							<a href="tel:<?php echo esc_attr( $phone ); ?>" class="text-sm text-gray-700 hover:text-primary"><?php echo esc_html( $phone ); ?></a>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $email ) : ?>
					<div class="flex items-start gap-3">
						<svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
						<div>
							<p class="text-xs font-medium text-gray-500"><?php esc_html_e( 'Email', 'flavor' ); ?></p>
							<a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-sm text-gray-700 hover:text-primary"><?php echo esc_html( $email ); ?></a>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $whatsapp ) : ?>
					<div class="flex items-start gap-3">
						<svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
						<div>
							<p class="text-xs font-medium text-gray-500"><?php esc_html_e( 'WhatsApp', 'flavor' ); ?></p>
							<a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $whatsapp ) ); ?>" target="_blank" rel="noopener" class="text-sm text-gray-700 hover:text-primary"><?php echo esc_html( $whatsapp ); ?></a>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $viber ) : ?>
					<div class="flex items-start gap-3">
						<svg class="w-5 h-5 text-purple-500 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M11.398.002C9.473.028 5.331.344 3.014 2.467 1.294 4.187.525 6.673.384 9.898.256 13.123.226 19.106 6.17 20.69h.004l-.004 2.37s-.04.96.592 1.155c.766.235 1.214-.493 1.945-1.282.402-.43.954-1.063 1.372-1.545 3.786.32 6.696-.41 7.03-.52.775-.255 5.158-.814 5.874-6.642.738-6.004-.358-9.797-2.36-11.505 0 0-1.543-1.407-5.478-1.637-.563-.032-1.163-.05-1.747-.082zm.158 1.712c.502.014 1.03.038 1.543.065 3.347.197 4.59 1.265 4.59 1.265 1.69 1.445 2.568 4.77 1.931 9.862-.604 4.903-4.175 5.262-4.851 5.484-.278.09-2.818.716-5.957.498 0 0-2.362 2.849-3.098 3.598-.117.128-.267.176-.363.148-.134-.04-.17-.193-.168-.428l.026-3.904c-5.017-1.335-4.724-6.386-4.614-9.12.117-2.733.752-4.864 2.206-6.293C4.752 1.968 8.456 1.608 11.556 1.714zm.558 2.741a.356.356 0 00-.003.712c1.06.01 1.96.393 2.678 1.138.716.745 1.076 1.632 1.076 2.638a.356.356 0 00.712.003c0-1.197-.433-2.266-1.296-3.165-.863-.897-1.934-1.318-3.167-1.326zm-3.85 1.24c-.202-.005-.406.082-.57.293l-.738.88c-.373.444-.26.968.033 1.325 0 0 .62.86 1.408 1.71.407.44.893.904 1.468 1.341.793.604 1.42.98 1.42.98l.004.002c.29.165.518.234.72.234.336 0 .544-.21.634-.302l.863-.878c.29-.296.27-.69-.047-.984l-1.74-1.367c-.31-.239-.693-.16-.95.096l-.62.63c-.065.066-.17.1-.32.01 0 0-.79-.42-1.547-1.04-.448-.366-.866-.79-1.147-1.17-.082-.14-.05-.252.017-.32l.607-.643c.237-.267.297-.646.05-.938l-1.002-1.285a.608.608 0 00-.464-.264zm6.575 1.14a.356.356 0 00-.003.712c1.274.032 1.972.74 2.083 2.116a.356.356 0 00.708-.067c-.134-1.68-1.059-2.728-2.788-2.761z"/></svg>
						<div>
							<p class="text-xs font-medium text-gray-500"><?php esc_html_e( 'Viber', 'flavor' ); ?></p>
							<a href="viber://chat?number=<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $viber ) ); ?>" class="text-sm text-gray-700 hover:text-primary"><?php echo esc_html( $viber ); ?></a>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $address ) : ?>
					<div class="flex items-start gap-3">
						<svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
						<div>
							<p class="text-xs font-medium text-gray-500"><?php esc_html_e( 'Address', 'flavor' ); ?></p>
							<p class="text-sm text-gray-700"><?php echo esc_html( $address ); ?></p>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $hours ) : ?>
					<div class="flex items-start gap-3">
						<svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
						<div>
							<p class="text-xs font-medium text-gray-500"><?php esc_html_e( 'Working Hours', 'flavor' ); ?></p>
							<p class="text-sm text-gray-700"><?php echo esc_html( $hours ); ?></p>
						</div>
					</div>
				<?php endif; ?>

				<!-- Social Links -->
				<?php if ( $facebook || $instagram ) : ?>
					<div class="border-t border-gray-200 pt-4">
						<p class="text-xs font-medium text-gray-500 mb-2"><?php esc_html_e( 'Follow Us', 'flavor' ); ?></p>
						<div class="flex gap-3">
							<?php if ( $facebook ) : ?>
								<a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 rounded-lg hover:border-primary hover:text-primary transition-colors">
									<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
								</a>
							<?php endif; ?>
							<?php if ( $instagram ) : ?>
								<a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 rounded-lg hover:border-primary hover:text-primary transition-colors">
									<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
								</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>

	</div>

</div>

<?php get_footer(); ?>
