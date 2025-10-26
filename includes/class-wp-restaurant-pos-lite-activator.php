<?php
/**
 * Fired during plugin activation
 *
 * @link       https://obydullah.com/wordpress-pos
 * @since      1.0.0
 *
 * @package    Wp_Restaurant_Pos_Lite
 */

class WP_Restaurant_POS_Lite_Activator {

    public static function activate() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $table_categories = $wpdb->prefix . 'pos_categories';
        $table_products   = $wpdb->prefix . 'pos_products';
        $table_stocks   = $wpdb->prefix . 'pos_stocks';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // 🔹 Categories Table
        $sql_categories = "CREATE TABLE $table_categories (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            status ENUM('active', 'inactive') DEFAULT 'active',
            PRIMARY KEY  (id)
        ) $charset_collate;";

        // 🔹 Products Table
        $sql_products = "CREATE TABLE $table_products (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            fk_category_id BIGINT(20) UNSIGNED NOT NULL,
            image VARCHAR(255) DEFAULT NULL,
            status ENUM('active', 'inactive') DEFAULT 'active',
            PRIMARY KEY  (id),
            KEY fk_category_id (fk_category_id),
            CONSTRAINT fk_category FOREIGN KEY (fk_category_id)
                REFERENCES $table_categories (id)
                ON DELETE CASCADE
        ) $charset_collate;";

        // 🔹 Stocks Table
        $sql_stocks = "CREATE TABLE $table_stocks (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            fk_product_id BIGINT(20) UNSIGNED NOT NULL,
            net_cost DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            sale_cost DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            quantity INT(11) NOT NULL DEFAULT 0,
            status ENUM('inStock', 'outStock', 'lowStock') DEFAULT 'inStock',
            PRIMARY KEY  (id),
            KEY fk_product_id (fk_product_id),
            CONSTRAINT fk_product FOREIGN KEY (fk_product_id)
                REFERENCES $table_products (id)
                ON DELETE CASCADE
        ) $charset_collate;";


        // Execute table creation
        dbDelta($sql_categories);
        dbDelta($sql_products);
        dbDelta($sql_stocks);

        // Optional: Insert a default category
        $default_category = $wpdb->get_var( "SELECT COUNT(*) FROM $table_categories" );
        if ( $default_category == 0 ) {
            $wpdb->insert(
                $table_categories,
                array(
                    'name'   => 'Uncategorized',
                    'status' => 'active',
                ),
                array('%s', '%s')
            );
        }
    }
}