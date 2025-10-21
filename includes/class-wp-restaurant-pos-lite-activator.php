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

        // Execute table creation
        dbDelta($sql_categories);
        dbDelta($sql_products);

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
