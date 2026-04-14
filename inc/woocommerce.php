<?php
/**
 * WooCommerce integration helpers.
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get the custom mega menu image attachment ID for a product category.
 *
 * @param int $term_id Product category term ID.
 * @return int
 */
function flavor_get_product_cat_mega_menu_image_id( $term_id ) {
	return absint( get_term_meta( $term_id, '_flavor_mega_menu_image_id', true ) );
}

/**
 * Render the admin preview markup for a mega menu category image.
 *
 * @param int $attachment_id Attachment ID.
 * @return string
 */
function flavor_get_product_cat_mega_menu_preview_html( $attachment_id ) {
	$attachment_id = absint( $attachment_id );

	if ( ! $attachment_id ) {
		return '';
	}

	$image_url = wp_get_attachment_image_url( $attachment_id, 'medium' );

	if ( ! $image_url ) {
		return '';
	}

	return sprintf(
		'<img src="%1$s" alt="" style="display:block;max-width:220px;width:100%%;height:auto;border-radius:8px;">',
		esc_url( $image_url )
	);
}

/**
 * Product category add form field for mega menu image.
 */
function flavor_product_cat_add_mega_menu_image_field() {
	?>
	<div class="form-field flavor-mega-menu-image-field">
		<label for="flavor-mega-menu-image-id"><?php esc_html_e( 'Mega Menu Image', 'flavor' ); ?></label>
		<input type="hidden" id="flavor-mega-menu-image-id" name="flavor_mega_menu_image_id" value="">
		<div class="flavor-mega-menu-image-preview" style="margin:12px 0;"></div>
		<div style="display:flex;gap:8px;align-items:center;">
			<button type="button" class="button flavor-mega-menu-image-upload"><?php esc_html_e( 'Select image', 'flavor' ); ?></button>
			<button type="button" class="button flavor-mega-menu-image-remove" style="display:none;"><?php esc_html_e( 'Remove image', 'flavor' ); ?></button>
		</div>
		<p class="description"><?php esc_html_e( 'Displayed on the right side of the desktop categories mega menu.', 'flavor' ); ?></p>
	</div>
	<?php
}
add_action( 'product_cat_add_form_fields', 'flavor_product_cat_add_mega_menu_image_field' );

/**
 * Product category edit form field for mega menu image.
 *
 * @param WP_Term $term Product category term.
 */
function flavor_product_cat_edit_mega_menu_image_field( $term ) {
	$image_id = flavor_get_product_cat_mega_menu_image_id( $term->term_id );
	?>
	<tr class="form-field flavor-mega-menu-image-field">
		<th scope="row">
			<label for="flavor-mega-menu-image-id"><?php esc_html_e( 'Mega Menu Image', 'flavor' ); ?></label>
		</th>
		<td>
			<input type="hidden" id="flavor-mega-menu-image-id" name="flavor_mega_menu_image_id" value="<?php echo esc_attr( $image_id ); ?>">
			<div class="flavor-mega-menu-image-preview" style="margin:0 0 12px;">
				<?php echo wp_kses_post( flavor_get_product_cat_mega_menu_preview_html( $image_id ) ); ?>
			</div>
			<div style="display:flex;gap:8px;align-items:center;">
				<button type="button" class="button flavor-mega-menu-image-upload"><?php esc_html_e( 'Select image', 'flavor' ); ?></button>
				<button type="button" class="button flavor-mega-menu-image-remove" <?php echo $image_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'Remove image', 'flavor' ); ?></button>
			</div>
			<p class="description"><?php esc_html_e( 'Displayed on the right side of the desktop categories mega menu.', 'flavor' ); ?></p>
		</td>
	</tr>
	<?php
}
add_action( 'product_cat_edit_form_fields', 'flavor_product_cat_edit_mega_menu_image_field' );

/**
 * Save product category mega menu image.
 *
 * @param int $term_id Product category term ID.
 */
function flavor_save_product_cat_mega_menu_image( $term_id ) {
	if ( ! isset( $_POST['flavor_mega_menu_image_id'] ) ) {
		return;
	}

	$image_id = absint( wp_unslash( $_POST['flavor_mega_menu_image_id'] ) );

	if ( $image_id ) {
		update_term_meta( $term_id, '_flavor_mega_menu_image_id', $image_id );
	} else {
		delete_term_meta( $term_id, '_flavor_mega_menu_image_id' );
	}
}
add_action( 'created_product_cat', 'flavor_save_product_cat_mega_menu_image' );
add_action( 'edited_product_cat', 'flavor_save_product_cat_mega_menu_image' );

/**
 * Enqueue media uploader support for product category mega menu images.
 *
 * @param string $hook_suffix Current admin page hook.
 */
function flavor_product_cat_mega_menu_admin_assets( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'edit-tags.php', 'term.php' ), true ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'product_cat' !== $screen->taxonomy ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_script( 'jquery' );

	$script = "
	jQuery(function($) {
		function updateField(field, attachment) {
			var input = field.find('input[name=\"flavor_mega_menu_image_id\"]');
			var preview = field.find('.flavor-mega-menu-image-preview');
			var remove = field.find('.flavor-mega-menu-image-remove');

			if (attachment && attachment.id) {
				input.val(attachment.id);
				preview.html('<img src=\"' + attachment.url + '\" alt=\"\" style=\"display:block;max-width:220px;width:100%;height:auto;border-radius:8px;\">');
				remove.show();
			} else {
				input.val('');
				preview.empty();
				remove.hide();
			}
		}

		$(document).on('click', '.flavor-mega-menu-image-upload', function(event) {
			event.preventDefault();

			var button = $(this);
			var field = button.closest('.flavor-mega-menu-image-field');
			var frame = wp.media({
				title: 'Select mega menu image',
				button: { text: 'Use image' },
				multiple: false
			});

			frame.on('select', function() {
				var attachment = frame.state().get('selection').first().toJSON();
				updateField(field, attachment);
			});

			frame.open();
		});

		$(document).on('click', '.flavor-mega-menu-image-remove', function(event) {
			event.preventDefault();
			updateField($(this).closest('.flavor-mega-menu-image-field'), null);
		});
	});
	";

	wp_add_inline_script( 'jquery', $script );
}
add_action( 'admin_enqueue_scripts', 'flavor_product_cat_mega_menu_admin_assets' );

/**
 * Add a manual special-offers checkbox to the WooCommerce product editor.
 */
function flavor_add_special_offers_product_field() {
	echo '<div class="options_group">';

	woocommerce_wp_checkbox(
		array(
			'id'            => '_flavor_show_in_special_offers',
			'label'         => __( 'Display in Special Offers', 'flavor' ),
			'description'   => __( 'Show this product in the homepage Special Offers section.', 'flavor' ),
			'desc_tip'      => true,
			'value'         => get_post_meta( get_the_ID(), '_flavor_show_in_special_offers', true ),
			'cbvalue'       => 'yes',
			'wrapper_class' => 'show_if_simple show_if_variable',
		)
	);

	echo '</div>';
}
add_action( 'woocommerce_product_options_general_product_data', 'flavor_add_special_offers_product_field' );

/**
 * Save the special-offers product checkbox.
 *
 * @param int $product_id Product ID.
 */
function flavor_save_special_offers_product_field( $product_id ) {
	$value = isset( $_POST['_flavor_show_in_special_offers'] ) ? 'yes' : 'no'; // phpcs:ignore WordPress.Security.NonceVerification.Missing

	if ( 'yes' === $value ) {
		update_post_meta( $product_id, '_flavor_show_in_special_offers', 'yes' );
	} else {
		delete_post_meta( $product_id, '_flavor_show_in_special_offers' );
	}
}
add_action( 'woocommerce_process_product_meta', 'flavor_save_special_offers_product_field' );

/**
 * Add the special-offers checkbox to product quick edit.
 */
function flavor_add_special_offers_product_quick_edit_field() {
	?>
	<label class="alignleft">
		<input type="checkbox" name="_flavor_show_in_special_offers" value="yes">
		<span class="checkbox-title"><?php esc_html_e( 'Display in Special Offers', 'flavor' ); ?></span>
	</label>
	<br class="clear" />
	<?php
}
add_action( 'woocommerce_product_quick_edit_start', 'flavor_add_special_offers_product_quick_edit_field' );

/**
 * Output hidden inline data used to prefill the special-offers quick edit checkbox.
 *
 * @param string $column_name Current column name.
 * @param int    $post_id     Product ID.
 */
function flavor_add_special_offers_product_quick_edit_data( $column_name, $post_id ) {
	if ( 'name' !== $column_name ) {
		return;
	}

	$enabled = 'yes' === get_post_meta( $post_id, '_flavor_show_in_special_offers', true ) ? 'yes' : 'no';

	printf(
		'<div class="hidden" id="flavor_inline_%1$d"><div class="show_in_special_offers">%2$s</div></div>',
		absint( $post_id ),
		esc_html( $enabled )
	);
}
add_action( 'manage_product_posts_custom_column', 'flavor_add_special_offers_product_quick_edit_data', 20, 2 );

/**
 * Save the special-offers quick edit checkbox.
 *
 * @param WC_Product $product Product object.
 */
function flavor_save_special_offers_product_quick_edit_field( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$value = isset( $_POST['_flavor_show_in_special_offers'] ) ? 'yes' : 'no'; // phpcs:ignore WordPress.Security.NonceVerification.Missing

	if ( 'yes' === $value ) {
		$product->update_meta_data( '_flavor_show_in_special_offers', 'yes' );
	} else {
		$product->delete_meta_data( '_flavor_show_in_special_offers' );
	}

	$product->save_meta_data();
}
add_action( 'woocommerce_product_quick_edit_save', 'flavor_save_special_offers_product_quick_edit_field' );

/**
 * Populate the special-offers quick edit checkbox from the current product row data.
 *
 * @param string $hook_suffix Current admin page hook.
 */
function flavor_special_offers_quick_edit_admin_assets( $hook_suffix ) {
	if ( 'edit.php' !== $hook_suffix ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'edit-product' !== $screen->id ) {
		return;
	}

	wp_enqueue_script( 'jquery' );

	$script = "
	jQuery(function($) {
		$('#the-list').on('click', '.editinline', function() {
			var postId = $(this).closest('tr').attr('id') || '';

			postId = postId.replace('post-', '');

			setTimeout(function() {
				var enabled = $('#flavor_inline_' + postId).find('.show_in_special_offers').text() === 'yes';
				$('#edit-' + postId).find('input[name=\"_flavor_show_in_special_offers\"]').prop('checked', enabled);
			}, 0);
		});
	});
	";

	wp_add_inline_script( 'jquery', $script );
}
add_action( 'admin_enqueue_scripts', 'flavor_special_offers_quick_edit_admin_assets' );
