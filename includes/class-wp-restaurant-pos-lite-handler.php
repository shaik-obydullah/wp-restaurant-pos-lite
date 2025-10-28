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
			__( 'Categories', 'wp-restaurant-pos-lite' ),
			__( 'Categories', 'wp-restaurant-pos-lite' ),
			'manage_options',
			'wp-restaurant-pos-lite-categories',
			[ $this, 'render_categories_page' ]
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
	 * Categories Page.
	 */
	
/**
 * Categories Page.
 */
public function render_categories_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'You do not have permission to access this page.', 'wp-restaurant-pos-lite' ) );
    }

    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Product Categories', 'wp-restaurant-pos-lite' ); ?></h1>
        <p><?php esc_html_e( 'Manage product categories such as Food, Drinks, Desserts, etc.', 'wp-restaurant-pos-lite' ); ?></p>

        <div id="category-ui" style="display: flex; gap: 40px; margin-top: 20px;">
            <!-- Add Category Form -->
            <div style="flex: 1; max-width: 400px;">
                <h2><?php esc_html_e( 'Add New Category', 'wp-restaurant-pos-lite' ); ?></h2>
                <form method="post">
                    <?php wp_nonce_field( 'wp_restaurant_pos_lite_add_category', 'wp_restaurant_pos_lite_nonce' ); ?>

                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="category_name"><?php esc_html_e( 'Category Name', 'wp-restaurant-pos-lite' ); ?></label></th>
                            <td><input name="category_name" type="text" id="category_name" class="regular-text" required></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="category_description"><?php esc_html_e( 'Description', 'wp-restaurant-pos-lite' ); ?></label></th>
                            <td><textarea name="category_description" id="category_description" class="large-text" rows="3"></textarea></td>
                        </tr>
                    </table>

                    <?php submit_button( __( 'Add Category', 'wp-restaurant-pos-lite' ) ); ?>
                </form>
            </div>

            <!-- Category List -->
            <div style="flex: 2;">
                <h2><?php esc_html_e( 'Existing Categories', 'wp-restaurant-pos-lite' ); ?></h2>
                <table class="widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php esc_html_e( 'ID', 'wp-restaurant-pos-lite' ); ?></th>
                            <th><?php esc_html_e( 'Name', 'wp-restaurant-pos-lite' ); ?></th>
                            <th><?php esc_html_e( 'Description', 'wp-restaurant-pos-lite' ); ?></th>
                            <th><?php esc_html_e( 'Actions', 'wp-restaurant-pos-lite' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Food</td>
                            <td>Main dishes and entrees</td>
                            <td><a href="#" class="button button-small disabled"><?php esc_html_e( 'Edit', 'wp-restaurant-pos-lite' ); ?></a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Drinks</td>
                            <td>Beverages and cold drinks</td>
                            <td><a href="#" class="button button-small disabled"><?php esc_html_e( 'Edit', 'wp-restaurant-pos-lite' ); ?></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
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