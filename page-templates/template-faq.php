<?php
/**
 * Template Name: FAQ
 *
 * @package Flavor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$sections = array(
	'about'     => array(
		'title' => __( 'About Us', 'flavor' ),
		'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>',
		'items' => array(
			array(
				'q' => __( 'Who are you?', 'flavor' ),
				'a' => __( 'We are a leading online retailer committed to providing the best products at competitive prices. With years of experience in e-commerce, we strive to deliver exceptional customer service and a seamless shopping experience.', 'flavor' ),
			),
			array(
				'q' => __( 'Where are you located?', 'flavor' ),
				'a' => __( 'Our headquarters are located in the heart of the city. We serve customers nationwide with fast and reliable shipping. Visit our Contact page for our full address and directions.', 'flavor' ),
			),
			array(
				'q' => __( 'What brands do you carry?', 'flavor' ),
				'a' => __( 'We partner with hundreds of trusted brands to offer you a wide selection of quality products. From popular household names to emerging brands, we curate our catalog to meet diverse needs and preferences.', 'flavor' ),
			),
		),
	),
	'payments'  => array(
		'title' => __( 'Payments', 'flavor' ),
		'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>',
		'items' => array(
			array(
				'q' => __( 'What payment methods do you accept?', 'flavor' ),
				'a' => __( 'We accept all major credit and debit cards (Visa, MasterCard, American Express), PayPal, bank transfers, and cash on delivery for eligible orders. All online payments are processed securely with SSL encryption.', 'flavor' ),
			),
			array(
				'q' => __( 'Is my payment information secure?', 'flavor' ),
				'a' => __( 'Absolutely. We use industry-standard SSL encryption and comply with PCI DSS requirements. We never store your full credit card details on our servers. All transactions are processed through certified payment gateways.', 'flavor' ),
			),
			array(
				'q' => __( 'Can I pay in installments?', 'flavor' ),
				'a' => __( 'Yes! For orders above a certain amount, we offer installment payment plans through our banking partners. You can select the installment option at checkout and choose a plan that suits your budget.', 'flavor' ),
			),
		),
	),
	'technical' => array(
		'title' => __( 'Technical', 'flavor' ),
		'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.1-3.67a3.18 3.18 0 01-.64-4.49l.1-.12a3.18 3.18 0 014.49-.64l5.1 3.67m-5.1 3.67l5.1 3.67a3.18 3.18 0 004.49-.64l.1-.12a3.18 3.18 0 00-.64-4.49l-5.1-3.67m-4.95 5.25l5.1 3.67"/>',
		'items' => array(
			array(
				'q' => __( 'Do your products come with a warranty?', 'flavor' ),
				'a' => __( 'Most products come with the manufacturer\'s standard warranty. Additionally, we offer an extended warranty option that you can add during checkout for extra peace of mind. Warranty terms vary by product category.', 'flavor' ),
			),
			array(
				'q' => __( 'How do I claim warranty service?', 'flavor' ),
				'a' => __( 'To claim warranty service, contact our support team with your order number and a description of the issue. We will guide you through the process, which may include troubleshooting steps, product return, or direct manufacturer contact.', 'flavor' ),
			),
			array(
				'q' => __( 'Do you provide product specifications?', 'flavor' ),
				'a' => __( 'Yes, detailed specifications are listed on each product page. If you need additional technical information that isn\'t listed, please contact our support team and we\'ll be happy to help.', 'flavor' ),
			),
		),
	),
	'shipping'  => array(
		'title' => __( 'Shipping', 'flavor' ),
		'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.143-.504 1.07-1.106a12.153 12.153 0 00-2.338-5.748L16.5 3.75h-4.5l-1.778 2.4m-1.472 5.1h7.5m-7.5 0l-.263 1.313M3.375 4.5h1.978c.49 0 .936.296 1.124.76l1.523 3.756"/>',
		'items' => array(
			array(
				'q' => __( 'How long does shipping take?', 'flavor' ),
				'a' => __( 'Standard shipping typically takes 2-5 business days. Express shipping is available for 1-2 business day delivery. Delivery times may vary based on your location and product availability.', 'flavor' ),
			),
			array(
				'q' => __( 'How much does shipping cost?', 'flavor' ),
				'a' => __( 'Shipping costs are calculated based on your location and order weight. Orders above a certain amount qualify for free shipping. You can see the exact shipping cost at checkout before placing your order.', 'flavor' ),
			),
			array(
				'q' => __( 'Do you ship internationally?', 'flavor' ),
				'a' => __( 'Currently we ship within the country. International shipping may be available for select products. Please contact our support team for international shipping inquiries.', 'flavor' ),
			),
		),
	),
	'orders'    => array(
		'title' => __( 'Orders', 'flavor' ),
		'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>',
		'items' => array(
			array(
				'q' => __( 'How do I track my order?', 'flavor' ),
				'a' => __( 'Once your order ships, you\'ll receive a tracking number via email. You can also track your order from your account dashboard under "Orders". Click on any order to see its current status and tracking information.', 'flavor' ),
			),
			array(
				'q' => __( 'Can I cancel or modify my order?', 'flavor' ),
				'a' => __( 'You can cancel or modify your order within 1 hour of placing it, provided it hasn\'t been shipped yet. Go to your account, find the order, and use the cancel/modify option. After shipping, you\'ll need to initiate a return instead.', 'flavor' ),
			),
			array(
				'q' => __( 'What is your return policy?', 'flavor' ),
				'a' => __( 'We offer a 30-day return policy for most products. Items must be in original condition and packaging. To start a return, contact our support team with your order number. Refunds are processed within 5-7 business days after we receive the returned item.', 'flavor' ),
			),
		),
	),
);
?>

<div class="max-w-site-xxl mx-auto px-3 md:px-4 py-6">

	<?php get_template_part( 'template-parts/global/breadcrumbs' ); ?>

	<h1 class="text-xl md:text-2xl font-bold text-gray-700 mb-6"><?php esc_html_e( 'Frequently Asked Questions', 'flavor' ); ?></h1>

	<div class="lg:grid lg:grid-cols-4 lg:gap-8">

		<!-- Sticky Side Nav -->
		<aside class="hidden lg:block lg:col-span-1">
			<nav class="sticky top-24 bg-gray-50 rounded-xl p-4">
				<ul class="space-y-1">
					<?php foreach ( $sections as $slug => $section ) : ?>
						<li>
							<a href="#faq-<?php echo esc_attr( $slug ); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-white hover:text-primary transition-colors">
								<svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><?php echo $section['icon']; // phpcs:ignore ?></svg>
								<?php echo esc_html( $section['title'] ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		</aside>

		<!-- Mobile Nav -->
		<div class="lg:hidden flex flex-wrap gap-2 mb-6">
			<?php foreach ( $sections as $slug => $section ) : ?>
				<a href="#faq-<?php echo esc_attr( $slug ); ?>" class="px-3 py-1.5 bg-gray-100 hover:bg-primary hover:text-white rounded-full text-xs font-medium text-gray-600 transition-colors">
					<?php echo esc_html( $section['title'] ); ?>
				</a>
			<?php endforeach; ?>
		</div>

		<!-- FAQ Content -->
		<div class="lg:col-span-3 space-y-10">
			<?php foreach ( $sections as $slug => $section ) : ?>
				<section id="faq-<?php echo esc_attr( $slug ); ?>" class="scroll-mt-24">
					<h2 class="text-lg font-bold text-gray-700 mb-4 flex items-center gap-2">
						<svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><?php echo $section['icon']; // phpcs:ignore ?></svg>
						<?php echo esc_html( $section['title'] ); ?>
					</h2>

					<div class="space-y-6">
						<?php foreach ( $section['items'] as $item ) : ?>
							<div>
								<h3 class="text-sm font-bold text-gray-700 mb-2"><?php echo esc_html( $item['q'] ); ?></h3>
								<p class="text-sm text-gray-600 leading-relaxed"><?php echo esc_html( $item['a'] ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endforeach; ?>

			<?php
			// Also render any page content from the editor
			while ( have_posts() ) :
				the_post();
				$content = get_the_content();
				if ( trim( $content ) ) :
			?>
				<section class="prose max-w-none">
					<?php the_content(); ?>
				</section>
			<?php
				endif;
			endwhile;
			?>
		</div>

	</div>

</div>

<?php get_footer(); ?>
