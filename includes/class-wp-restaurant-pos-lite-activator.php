<?php
/**
 * Fired during plugin activation
 *
 * @link       https://obydullah.com/wordpress-pos
 * @since      1.0.0
 *
 * @package    Wp_Restaurant_Pos_Lite
 */

class WP_Restaurant_POS_Lite_Activator
{
    public static function activate()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $table_categories = $wpdb->prefix . 'pos_categories';
        $table_products = $wpdb->prefix . 'pos_products';
        $table_stocks = $wpdb->prefix . 'pos_stocks';
        $table_stock_adjustments = $wpdb->prefix . 'pos_stock_adjustments';
        $table_customers = $wpdb->prefix . 'pos_customers';
        $table_sales = $wpdb->prefix . 'pos_sales';
        $table_accounting = $wpdb->prefix . 'pos_accounting';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // 🔹 Categories Table
        $sql_categories = "CREATE TABLE $table_categories (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            status ENUM('active', 'inactive') DEFAULT 'active',
            PRIMARY KEY (id)
        ) $charset_collate;";

        // 🔹 Products Table
        $sql_products = "CREATE TABLE $table_products (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            fk_category_id BIGINT(20) UNSIGNED NOT NULL,
            image VARCHAR(255) DEFAULT NULL,
            status ENUM('active', 'inactive') DEFAULT 'active',
            PRIMARY KEY (id),
            KEY fk_category_id (fk_category_id),
            CONSTRAINT fk_pos_product_category FOREIGN KEY (fk_category_id)
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
            PRIMARY KEY (id),
            KEY fk_product_id (fk_product_id),
            CONSTRAINT fk_pos_stock_product FOREIGN KEY (fk_product_id)
                REFERENCES $table_products (id)
                ON DELETE CASCADE
        ) $charset_collate;";

        // 🔹 Stock Adjustments Table
        $sql_stock_adjustments = "CREATE TABLE $table_stock_adjustments (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            fk_product_id BIGINT(20) UNSIGNED NOT NULL,
            adjustment_type ENUM('increase','decrease') NOT NULL,
            quantity INT(11) NOT NULL,
            note TEXT DEFAULT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY fk_product_id (fk_product_id),
            CONSTRAINT fk_pos_adjustment_product FOREIGN KEY (fk_product_id)
                REFERENCES {$wpdb->prefix}pos_products(id)
                ON DELETE CASCADE
        ) $charset_collate;";

        // 🔹 Customers Table
        $sql_customers = "CREATE TABLE $table_customers (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            balance DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            mobile VARCHAR(20) DEFAULT NULL,
            status ENUM('active','inactive') DEFAULT 'active',
            PRIMARY KEY (id)
        ) $charset_collate;";

        // 🔹 Sales Table
        $sql_sales = "CREATE TABLE $table_sales (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            fk_customer_id BIGINT(20) UNSIGNED DEFAULT NULL,
            invoice_id VARCHAR(30) DEFAULT NULL,
            net_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            vat_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            tax_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            shipping_cost DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            discount_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            grand_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            paid_amount DECIMAL(10,2) DEFAULT NULL,
            buy_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            sale_due DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            status ENUM('saveSale','completed','canceled') NOT NULL DEFAULT 'completed',
            note TEXT DEFAULT NULL,
            PRIMARY KEY (id),
            KEY fk_customer_id (fk_customer_id),
            CONSTRAINT fk_pos_sale_customer FOREIGN KEY (fk_customer_id)
                REFERENCES $table_customers (id)
                ON DELETE SET NULL
        ) $charset_collate;";

        // 🔹 Accounting Table
        $sql_accounting = "CREATE TABLE $table_accounting (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            in_amount DECIMAL(10,2) DEFAULT NULL,
            out_amount DECIMAL(10,2) DEFAULT NULL,
            amount_payable DECIMAL(10,2) DEFAULT NULL,
            amount_receivable DECIMAL(10,2) DEFAULT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        // Execute table creation
        dbDelta($sql_categories);
        dbDelta($sql_products);
        dbDelta($sql_stocks);
        dbDelta($sql_stock_adjustments);
        dbDelta($sql_customers);
        dbDelta($sql_sales);
        dbDelta($sql_accounting);

        // 🔹 Seed Default Categories (safe seeding with duplicate check)
        $default_categories = array(
            array('name' => 'Starter', 'status' => 'inactive'),
            array('name' => 'Main Dish', 'status' => 'inactive'),
            array('name' => 'Dessert', 'status' => 'inactive'),
            array('name' => 'Cold Drink', 'status' => 'inactive'),
            array('name' => 'Hot Drink', 'status' => 'inactive'),
            array('name' => 'Salad', 'status' => 'inactive'),
            array('name' => 'Vegetarian', 'status' => 'inactive'),
        );

        foreach ($default_categories as $category) {
            $exists = $wpdb->get_var(
                $wpdb->prepare("SELECT COUNT(*) FROM $table_categories WHERE name = %s", $category['name'])
            );

            if ((int) $exists === 0) {
                $wpdb->insert($table_categories, $category, array('%s', '%s'));
            }
        }
    }
}
