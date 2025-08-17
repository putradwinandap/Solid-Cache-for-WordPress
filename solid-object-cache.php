<?php
/**
 * Plugin Name: Solid Cache for WordPress
 * Plugin URI:  https://github.com/putradwinandap/Solid-Cache-for-WordPress
 * Description: Developer-friendly cache helper for WordPress. Supports Object and Fragment caching.
 * Version:     0.1.0
 * Author:      Putra Dwi Nanda Prijambodo
 * Author URI:  https://putradwinandap.com
 * Text Domain: ptrsoc
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

define('PTRSOC_FILE', __FILE__);
define('PTRSOC_DIR', plugin_dir_path(__FILE__));
define('PTRSOC_URL', plugin_dir_url(__FILE__));
define('PTRSOC_BASENAME', plugin_basename(__FILE__));
define('PTRSOC_VERSION', '0.0.1');
define('PTRSOC_TEXTDOMAIN', 'PTRSOC');

require_once __DIR__ . '/bootstrap.php';