<?php
/**
 * Plugin Name:       WP Restaurant POS Lite
 * Plugin URI:        https://obydullah.com/wordpress-pos
 * Description:       A lightweight Point of Sale (POS) plugin for restaurant and retail businesses. Manage products, categories, customers, and sales directly from WordPress.
 * Version:           1.0.0
 * Author:            Shaik Obydullah
 * Author URI:        https://obydullah.com
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-restaurant-pos-lite
 * Domain Path:       /languages
 *
 * @package           Wp_Restaurant_Pos_Lite
 */

if ( ! defined( 'WPINC' ) ) {
	exit; // Prevent direct access.
}

/**
 * Current plugin version.
 */
define( 'WP_RESTAURANT_POS_LITE_VERSION', '1.0.0' );

/**
 * Define plugin constants.
 */
define( 'WP_RESTAURANT_POS_LITE_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_RESTAURANT_POS_LITE_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_RESTAURANT_POS_LITE_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Include activator and deactivator.
 */
require_once WP_RESTAURANT_POS_LITE_PATH . 'includes/class-wp-restaurant-pos-lite-activator.php';
require_once WP_RESTAURANT_POS_LITE_PATH . 'includes/class-wp-restaurant-pos-lite-deactivator.php';

/**
 * Activation and deactivation hooks.
 */
function activate_wp_restaurant_pos_lite() {
	WP_Restaurant_POS_Lite_Activator::activate();
}
function deactivate_wp_restaurant_pos_lite() {
	WP_Restaurant_POS_Lite_Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activate_wp_restaurant_pos_lite' );
register_deactivation_hook( __FILE__, 'deactivate_wp_restaurant_pos_lite' );

/**
 * Main plugin execution.
 */
function run_wp_restaurant_pos_lite() {

	// Load text domain
	load_plugin_textdomain( 'wp-restaurant-pos-lite', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	// Include the admin handler
	require_once WP_RESTAURANT_POS_LITE_PATH . 'includes/class-wp-restaurant-pos-lite-handler.php';

	// Initialize the handler (handles menus, etc.)
	new WP_Restaurant_POS_Lite_Handler();
}
add_action( 'plugins_loaded', 'run_wp_restaurant_pos_lite' );
