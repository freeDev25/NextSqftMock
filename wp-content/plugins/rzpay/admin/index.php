<?php
/**
 * Rzpay Admin
 *
 * Main admin file that loads all admin functionality
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load admin pages
require_once dirname(__FILE__) . '/admin-page.php';

// Load scripts and styles
require_once dirname(__FILE__) . '/load-scripts.php';

// Silence is golden
