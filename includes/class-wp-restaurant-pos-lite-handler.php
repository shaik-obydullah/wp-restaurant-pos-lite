<?php
/**
 * Handles admin menu and navigation for WP Restaurant POS Lite.
 *
 * @link       https://obydullah.com/wordpress-pos
 * @since      1.0.0
 *
 * @package    Wp_Restaurant_Pos_Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WP_Restaurant_POS_Lite_Handler {

	/**
	 * Initialize hooks.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ] );
	}

	/**
	 * Register the admin menu and submenus.
	 *
	 * @return void
	 */
	public function register_admin_menu() {

		// 🔹 Top-level menu.
		add_menu_page(
			__( 'Restaurant POS', 'wp-restaurant-pos-lite' ), // Page title
			__( 'Restaurant POS', 'wp-restaurant-pos-lite' ), // Menu title
			'manage_options',                                // Capability
			'wp-restaurant-pos-lite',                        // Menu slug
			[ $this, 'render_dashboard_page' ],              // Callback
			'dashicons-store',                               // Icon
			25                                               // Position
		);

		// 🔹 Submenus
		add_submenu_page(
			'wp-restaurant-pos-lite',
			__( 'Dashboard', 'wp-restaurant-pos-lite' ),
			__( 'Dashboard', 'wp-restaurant-pos-lite' ),
			'manage_options',
			'wp-restaurant-pos-lite',
			[ $this, 'render_dashboard_page' ]
		);

		add_submenu_page(
			'wp-restaurant-pos-lite',
			__( 'Products', 'wp-restaurant-pos-lite' ),
			__( 'Products', 'wp-restaurant-pos-lite' ),
			'manage_options',
			'wp-restaurant-pos-lite-products',
			[ $this, 'render_products_page' ]
		);

		add_submenu_page(
			'wp-restaurant-pos-lite',
			__( 'Sales', 'wp-restaurant-pos-lite' ),
			__( 'Sales', 'wp-restaurant-pos-lite' ),
			'manage_options',
			'wp-restaurant-pos-lite-sales',
			[ $this, 'render_sales_page' ]
		);

		add_submenu_page(
			'wp-restaurant-pos-lite',
			__( 'Customers', 'wp-restaurant-pos-lite' ),
			__( 'Customers', 'wp-restaurant-pos-lite' ),
			'manage_options',
			'wp-restaurant-pos-lite-customers',
			[ $this, 'render_customers_page' ]
		);

		add_submenu_page(
			'wp-restaurant-pos-lite',
			__( 'Settings', 'wp-restaurant-pos-lite' ),
			__( 'Settings', 'wp-restaurant-pos-lite' ),
			'manage_options',
			'wp-restaurant-pos-lite-settings',
			[ $this, 'render_settings_page' ]
		);
	}

	/**
	 * Dashboard Page.
	 */
	public function render_dashboard_page() {
		echo '<div class="wrap"><h1>' . esc_html__( 'Restaurant POS Dashboard', 'wp-restaurant-pos-lite' ) . '</h1>';
		echo '<p>' . esc_html__( 'Welcome to WP Restaurant POS Lite. Manage your POS data here.', 'wp-restaurant-pos-lite' ) . '</p></div>';
	}

	/**
	 * Products Page.
	 */
	public function render_products_page() {
		echo '<div class="wrap"><h1>' . esc_html__( 'Products', 'wp-restaurant-pos-lite' ) . '</h1>';
		echo '<p>' . esc_html__( 'Manage your menu items and product stock.', 'wp-restaurant-pos-lite' ) . '</p></div>';
	}

	/**
	 * Sales Page.
	 */
	public function render_sales_page() {
		echo '<div class="wrap"><h1>' . esc_html__( 'Sales', 'wp-restaurant-pos-lite' ) . '</h1>';
		echo '<p>' . esc_html__( 'View and manage your sales transactions.', 'wp-restaurant-pos-lite' ) . '</p></div>';
	}

	/**
	 * Customers Page.
	 */
	public function render_customers_page() {
		echo '<div class="wrap"><h1>' . esc_html__( 'Customers', 'wp-restaurant-pos-lite' ) . '</h1>';
		echo '<p>' . esc_html__( 'Manage your customers and their balances.', 'wp-restaurant-pos-lite' ) . '</p></div>';
	}

	/**
	 * Settings Page.
	 */
	public function render_settings_page() {
		echo '<div class="wrap"><h1>' . esc_html__( 'Settings', 'wp-restaurant-pos-lite' ) . '</h1>';
		echo '<p>' . esc_html__( 'Configure plugin preferences and accounting options.', 'wp-restaurant-pos-lite' ) . '</p></div>';
	}
}