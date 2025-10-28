<?php
/**
 * Admin page for managing POS categories
 *
 * @package Wp_Restaurant_Pos_Lite
 */

class WP_Restaurant_POS_Lite_Categories {

    public static function render_categories_page() {
        global $wpdb;
        $table_categories = $wpdb->prefix . 'pos_categories';

        // Handle form submission (Add new category)
        if (isset($_POST['pos_category_submit'])) {
            $name = sanitize_text_field($_POST['category_name']);
            $status = sanitize_text_field($_POST['category_status']);

            if (!empty($name)) {
                $wpdb->insert(
                    $table_categories,
                    [
                        'name'   => $name,
                        'status' => $status,
                    ],
                    ['%s', '%s']
                );
                echo '<div class="updated notice"><p>Category added successfully!</p></div>';
            } else {
                echo '<div class="error notice"><p>Please enter a category name.</p></div>';
            }
        }

        // Fetch all categories
        $categories = $wpdb->get_results("SELECT * FROM $table_categories ORDER BY id DESC");
        ?>

        <div class="wrap">
            <h1 class="wp-heading-inline">POS Categories</h1>
            <hr class="wp-header-end">

            <h2>Add New Category</h2>
            <form method="post" style="margin-bottom: 30px;">
                <table class="form-table">
                    <tr>
                        <th><label for="category_name">Category Name</label></th>
                        <td><input name="category_name" type="text" id="category_name" class="regular-text" required></td>
                    </tr>
                    <tr>
                        <th><label for="category_status">Status</label></th>
                        <td>
                            <select name="category_status" id="category_status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" name="pos_category_submit" id="submit" class="button button-primary" value="Add Category">
                </p>
            </form>

            <h2>All Categories</h2>
            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($categories): ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo esc_html($category->id); ?></td>
                                <td><?php echo esc_html($category->name); ?></td>
                                <td><?php echo esc_html(ucfirst($category->status)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align:center;">No categories found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php
    }
}
