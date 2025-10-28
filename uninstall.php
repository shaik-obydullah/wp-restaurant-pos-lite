<?php
/**
 * Triggered when the plugin is uninstalled.
 *
 * @link       https://obydullah.com/wordpress-pos
 * @since      1.0.0
 *
 * @package    Wp_Restaurant_Pos_Lite
 */

// Exit if accessed directly or if not uninstalling properly
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

// List of plugin-created tables
$tables = [
    "{$wpdb->prefix}pos_categories",
    "{$wpdb->prefix}pos_products",
    "{$wpdb->prefix}pos_stocks",
    "{$wpdb->prefix}pos_stock_adjustments",
    "{$wpdb->prefix}pos_customers",
    "{$wpdb->prefix}pos_sales",
    "{$wpdb->prefix}pos_accounting",
];

// Drop each table safely
foreach ($tables as $table) {
    $wpdb->query("DROP TABLE IF EXISTS $table");
}

/**
 * Remove plugin-specific options or settings
 *
 * Only do this if you are sure users expect a full cleanup on uninstall.
 */
delete_option( 'wp_restaurant_pos_lite_settings' );       // General settings
delete_option( 'wp_restaurant_pos_lite_version' );        // Plugin version tracking
delete_option( 'wp_restaurant_pos_lite_license_key' );    // (If applicable)
delete_option( 'wp_restaurant_pos_lite_data_migrated' );  // Example migration flag

/**
 * Remove transient cache (if used)
 */
// delete_transient( 'wp_restaurant_pos_lite_cache' );

/**
 * Optional: Cleanup site options for multisite installations
 */
if ( is_multisite() ) {
    $sites = get_sites();
    foreach ( $sites as $site ) {
        switch_to_blog( $site->blog_id );

        // Drop tables for each site
        foreach ( $tables as $table ) {
            $wpdb->query( "DROP TABLE IF EXISTS $table" );
        }

        // Delete plugin-specific options in each site
        delete_option( 'wp_restaurant_pos_lite_settings' );
        delete_option( 'wp_restaurant_pos_lite_version' );
        delete_option( 'wp_restaurant_pos_lite_license_key' );

        restore_current_blog();
    }
}
