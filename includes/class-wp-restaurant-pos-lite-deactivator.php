<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://obydullah.com/wordpress-pos
 * @since      1.0.0
 *
 * @package    Wp_Restaurant_Pos_Lite
 */

class WP_Restaurant_POS_Lite_Deactivator {

    public static function deactivate() {
        // Example: remove plugin-specific options, transient, or scheduled tasks.
        // Data (tables) should usually be kept on deactivation.

        // wp_clear_scheduled_hook('wp_restaurant_pos_lite_sync_cron'); // if you have CRON jobs
    }
}
