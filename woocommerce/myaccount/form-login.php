<?php
/**
 * Login/Register Form - Flavor Theme
 *
 * @package Flavor
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_customer_login_form' );

$registration_enabled = 'yes' === get_option( 'woocommerce_enable_myaccount_registration' );
?>

<div class="container-site py-8 lg:py-12" x-data="{ tab: 'login' }">

    <?php if ( $registration_enabled ) : ?>
        <!-- Mobile Tabs -->
        <div class="flex lg:hidden mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-1">
            <button @click="tab = 'login'"
                    :class="tab === 'login' ? 'bg-[var(--color-primary,#E15726)] text-white' : 'text-gray-600'"
                    class="flex-1 py-2.5 text-sm font-semibold rounded-md transition-colors">
                <?php esc_html_e( 'Login', 'flavor' ); ?>
            </button>
            <button @click="tab = 'register'"
                    :class="tab === 'register' ? 'bg-[var(--color-primary,#E15726)] text-white' : 'text-gray-600'"
                    class="flex-1 py-2.5 text-sm font-semibold rounded-md transition-colors">
                <?php esc_html_e( 'Register', 'flavor' ); ?>
            </button>
        </div>
    <?php endif; ?>

    <div class="grid gap-8 <?php echo $registration_enabled ? 'lg:grid-cols-2' : 'max-w-md mx-auto'; ?>">

        <!-- Login Form -->
        <div :class="{ 'hidden lg:block': tab !== 'login' }" x-cloak class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 lg:p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6"><?php esc_html_e( 'Login', 'flavor' ); ?></h2>

            <form method="post" class="space-y-5">

                <?php do_action( 'woocommerce_login_form_start' ); ?>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                        <?php esc_html_e( 'Username or email address', 'flavor' ); ?> <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="username" name="username" autocomplete="username"
                           value="<?php echo isset( $_POST['username'] ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:outline-none transition-colors" required />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        <?php esc_html_e( 'Password', 'flavor' ); ?> <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password" name="password" autocomplete="current-password"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:outline-none transition-colors" required />
                </div>

                <?php do_action( 'woocommerce_login_form' ); ?>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="rememberme" value="forever"
                               class="rounded border-gray-300 text-primary focus:ring-primary" />
                        <span class="text-sm text-gray-600"><?php esc_html_e( 'Remember me', 'flavor' ); ?></span>
                    </label>
                    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="text-sm text-[var(--color-primary,#E15726)] hover:underline">
                        <?php esc_html_e( 'Lost your password?', 'flavor' ); ?>
                    </a>
                </div>

                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

                <button type="submit" name="login" value="1"
                        class="w-full py-3 bg-[var(--color-primary,#E15726)] text-white font-semibold rounded-lg hover:opacity-90 transition-opacity">
                    <?php esc_html_e( 'Log in', 'flavor' ); ?>
                </button>

                <?php do_action( 'woocommerce_login_form_end' ); ?>

            </form>
        </div>

        <?php if ( $registration_enabled ) : ?>
            <!-- Register Form -->
            <div :class="{ 'hidden lg:block': tab !== 'register' }" x-cloak class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 lg:p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6"><?php esc_html_e( 'Register', 'flavor' ); ?></h2>

                <form method="post" class="space-y-5" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

                    <?php do_action( 'woocommerce_register_form_start' ); ?>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                        <div>
                            <label for="reg_username" class="block text-sm font-medium text-gray-700 mb-1">
                                <?php esc_html_e( 'Username', 'flavor' ); ?> <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="reg_username" name="username" autocomplete="username"
                                   value="<?php echo isset( $_POST['username'] ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:outline-none transition-colors" required />
                        </div>
                    <?php endif; ?>

                    <div>
                        <label for="reg_email" class="block text-sm font-medium text-gray-700 mb-1">
                            <?php esc_html_e( 'Email address', 'flavor' ); ?> <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="reg_email" name="email" autocomplete="email"
                               value="<?php echo isset( $_POST['email'] ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:outline-none transition-colors" required />
                    </div>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                        <div>
                            <label for="reg_password" class="block text-sm font-medium text-gray-700 mb-1">
                                <?php esc_html_e( 'Password', 'flavor' ); ?> <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="reg_password" name="password" autocomplete="new-password"
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white focus:outline-none transition-colors" required />
                        </div>
                    <?php endif; ?>

                    <?php do_action( 'woocommerce_register_form' ); ?>

                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

                    <button type="submit" name="register" value="1"
                            class="w-full py-3 bg-[var(--color-primary,#E15726)] text-white font-semibold rounded-lg hover:opacity-90 transition-opacity">
                        <?php esc_html_e( 'Register', 'flavor' ); ?>
                    </button>

                    <?php do_action( 'woocommerce_register_form_end' ); ?>

                </form>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
