# Copilot Instructions for NextSqftMock (WordPress/XAMPP)

## Project Overview
- This is a local WordPress development environment, running under XAMPP, with custom plugins and themes.
- The main custom logic is in `wp-content/plugins/rzpay/`, which implements subscription management, user features, and payment integration.
- The codebase extends WordPress using custom post types, admin pages, metaboxes, and custom database tables.

## Key Components
- **Custom Post Type:** `subscription` (see `subscription-admin.php`)
- **Custom Admin Pages:** Added as subpages under the Subscriptions menu (see `subscription-user-list.php`, `subscription-features.php`)
- **Metaboxes:** Used for subscription details and feature limits (see `subscription-features-metabox.php`)
- **Custom Tables:**
  - `wp_rzpay_user_subscriptions` (user-subscription mapping, status, dates)
  - `wp_subscription_features` (feature definitions)
- **REST API:** Custom fields are exposed for the `subscription` post type.

## Developer Workflows
- **Local Dev:** Place the project in XAMPP's `htdocs` and access via `http://localhost/nxtest`.
- **Plugin Development:** Edit files in `wp-content/plugins/rzpay/`. Activate/deactivate plugins via the WordPress admin.
- **DB Schema:** Custom tables are created on plugin activation (see `includes/subscription.php`, `includes/features.php`).
- **Admin UI:**
  - Use WP_List_Table for admin lists (see `subscription-user-list.php`).
  - Use WordPress CSS classes for UI consistency.
  - Features and limits are managed via metaboxes and custom admin pages.

## Project-Specific Patterns
- **Admin Columns:** Custom columns (e.g., active user count) are added to the subscription list via filters/actions in `subscription-admin.php`.
- **Feature Limits:** Feature limits for subscriptions are stored as post meta with keys like `feature_limit_{feature_slug}`.
- **Bulk Actions & Sorting:** Use WP_List_Table conventions for sortable columns and bulk actions.
- **No Direct SQL in Templates:** All DB access is done in PHP logic, not in view templates.
- **Script/Style Management:** 
  - Create dedicated `load-scripts.php` files in each module directory.
  - Include these files via `require_once` in the nearest `index.php` file.
  - For admin-specific scripts/styles, use the `admin_enqueue_scripts` hook.
  - For frontend scripts/styles, use the `wp_enqueue_scripts` hook.
  - Always check page context before loading scripts to prevent unnecessary loading.

## Integration Points
- **Razorpay:** Payment integration is in `wp-content/plugins/rzpay/vendor/razorpay/`.
- **Custom REST Fields:** Registered in `subscription-admin.php` for API consumers.

## Examples
- To add a new admin page, use `add_submenu_page` under the `subscription` post type.
- To add a new feature, update `subscription-features.php` and ensure the DB table is updated.
- To add a new column to the admin list, use `manage_{post_type}_posts_columns` and `manage_{post_type}_posts_custom_column` hooks.
- To add new scripts or styles:
  ```php
  // In /module/load-scripts.php
  function module_admin_scripts($hook) {
      // Only load on specific pages
      if (strpos($hook, 'module') === false) {
          return;
      }
      
      wp_enqueue_script(
          'module-admin-script',
          plugin_dir_url(dirname(__FILE__)) . 'assets/admin.js',
          ['jquery'],
          '1.0.0',
          true
      );
  }
  add_action('admin_enqueue_scripts', 'module_admin_scripts');
  
  // In /module/index.php
  require_once dirname(__FILE__) . '/load-scripts.php';
  ```

## References
- See `wp-content/plugins/rzpay/subscription/admin/` for all admin customizations.
- See `wp-content/plugins/rzpay/subscription/includes/` for DB and business logic.
- See `README.md` for local setup.

---

If you add new admin pages, custom tables, or workflows, update this file with examples and conventions.
