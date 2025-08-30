<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_nxt');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', '');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Z|_`/e~6Jr@MAAD/Rl7A5DvC34uOY{)sH5I?^P}>T-~ltlTubjlrF>}3SF^([W:c');
define('SECURE_AUTH_KEY',  ':.`;)*p+}1-`Akd$-fTTIllv_Qdn .8YrkRaC5bu<3@fxK6Z[F>dyI}=izvrc(;i');
define('LOGGED_IN_KEY',    'q^HijFz>yl1ItcK 0/ll7hT `EZ`HV[<GKs[j<KhN+`q<(G$(LBEXG]qzKW/guzv');
define('NONCE_KEY',        'MX+h^yD&`#d+[$Z,v=a!bQ#^yR[]>2),&|T2VQ!@.XSThd6ZX?BH*RpbE#M)Xjnq');
define('AUTH_SALT',        'xSUkq8Z/@W_bew2^QxgH+II/GNaq[@IbxHCn~|mgv^<C;%?9SP}S}GAFi*[h>o[y');
define('SECURE_AUTH_SALT', '&tkLfnW:3i.uXz*%.P4ReS(CTetHp8Rm]d?+U$!jPT@u6Y}}vB=g<MNR>=WFfPEy');
define('LOGGED_IN_SALT',   'S8sX%`AL?Zqd~]yt.4!W>^AU1FD]l^~M@W=|lG%v||5#mY8j.LrERT<AEY4tspJi');
define('NONCE_SALT',       'CX*lU)xT.CxAy0okx*Y#.tDmK{moR]MNaF?s%|u9AM(-0Ob$_2JX>]O>QV>~bz3W');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
