<?php
/**
 * Edit Account Form - Flavor Theme
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

$user = wp_get_current_user();
$store_credit = get_user_meta( $user->ID, '_store_credit', true );

do_action( 'woocommerce_before_edit_account_form' );
?>

<div class="space-y-6">

    <!-- Store Credit -->
    <?php if ( $store_credit ) : ?>
        <div class="bg-green-50 border border-green-200 rounded-lg p-5 flex items-center gap-4">
            <div class="shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-green-700"><?php esc_html_e( 'Store Credit Balance', 'flavor' ); ?></p>
                <p class="text-xl font-bold text-green-800"><?php echo wp_kses_post( wc_price( $store_credit ) ); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Account Details Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 lg:p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6"><?php esc_html_e( 'Account Details', 'flavor' ); ?></h2>

        <form method="post" class="space-y-6" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>

            <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="account_first_name" class="block text-sm font-medium text-gray-700 mb-1">
                        <?php esc_html_e( 'First name', 'flavor' ); ?> <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="account_first_name" name="account_first_name"
                           value="<?php echo esc_attr( $user->first_name ); ?>"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[var(--color-primary,#E15726)] focus:ring-[var(--color-primary,#E15726)]" required />
                </div>
                <div>
                    <label for="account_last_name" class="block text-sm font-medium text-gray-700 mb-1">
                        <?php esc_html_e( 'Last name', 'flavor' ); ?> <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="account_last_name" name="account_last_name"
                           value="<?php echo esc_attr( $user->last_name ); ?>"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[var(--color-primary,#E15726)] focus:ring-[var(--color-primary,#E15726)]" required />
                </div>
            </div>

            <div>
                <label for="account_display_name" class="block text-sm font-medium text-gray-700 mb-1">
                    <?php esc_html_e( 'Display name', 'flavor' ); ?> <span class="text-red-500">*</span>
                </label>
                <input type="text" id="account_display_name" name="account_display_name"
                       value="<?php echo esc_attr( $user->display_name ); ?>"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[var(--color-primary,#E15726)] focus:ring-[var(--color-primary,#E15726)]" required />
                <p class="mt-1 text-xs text-gray-500"><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews.', 'flavor' ); ?></p>
            </div>

            <div>
                <label for="account_email" class="block text-sm font-medium text-gray-700 mb-1">
                    <?php esc_html_e( 'Email address', 'flavor' ); ?> <span class="text-red-500">*</span>
                </label>
                <input type="email" id="account_email" name="account_email"
                       value="<?php echo esc_attr( $user->user_email ); ?>"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[var(--color-primary,#E15726)] focus:ring-[var(--color-primary,#E15726)]" required />
            </div>

            <!-- Password Change -->
            <fieldset class="border-t border-gray-200 pt-6">
                <legend class="text-lg font-semibold text-gray-900 mb-4"><?php esc_html_e( 'Password Change', 'flavor' ); ?></legend>

                <div class="space-y-5">
                    <div>
                        <label for="password_current" class="block text-sm font-medium text-gray-700 mb-1">
                            <?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'flavor' ); ?>
                        </label>
                        <input type="password" id="password_current" name="password_current" autocomplete="off"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[var(--color-primary,#E15726)] focus:ring-[var(--color-primary,#E15726)]" />
                    </div>
                    <div>
                        <label for="password_1" class="block text-sm font-medium text-gray-700 mb-1">
                            <?php esc_html_e( 'New password (leave blank to leave unchanged)', 'flavor' ); ?>
                        </label>
                        <input type="password" id="password_1" name="password_1" autocomplete="new-password"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[var(--color-primary,#E15726)] focus:ring-[var(--color-primary,#E15726)]" />
                    </div>
                    <div>
                        <label for="password_2" class="block text-sm font-medium text-gray-700 mb-1">
                            <?php esc_html_e( 'Confirm new password', 'flavor' ); ?>
                        </label>
                        <input type="password" id="password_2" name="password_2" autocomplete="new-password"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[var(--color-primary,#E15726)] focus:ring-[var(--color-primary,#E15726)]" />
                    </div>
                </div>
            </fieldset>

            <?php do_action( 'woocommerce_edit_account_form' ); ?>

            <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
            <input type="hidden" name="action" value="save_account_details" />

            <button type="submit" name="save_account_details"
                    class="px-8 py-3 bg-[var(--color-primary,#E15726)] text-white font-semibold rounded-lg hover:opacity-90 transition-opacity">
                <?php esc_html_e( 'Save changes', 'flavor' ); ?>
            </button>

            <?php do_action( 'woocommerce_edit_account_form_end' ); ?>

        </form>
    </div>
</div>
