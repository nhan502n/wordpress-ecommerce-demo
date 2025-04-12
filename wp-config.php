<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_web2' );

/** Database username */
define( 'DB_USER', 'nhanorder' );

/** Database password */
define( 'DB_PASSWORD', 'Rf*L:Ka0f98s2P' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define('AUTH_KEY', 'QyIdGQQ6R1jw1*M&@dH8[El]TK*ZNv3RC6O0nR16751|jmiE4/vFb2O~xs%8x6rR');
define('SECURE_AUTH_KEY', 'qxyAAAI[j4p-1PSc/u#Xs3xef4&H18~i%8L0Jo06f79:iy71J7N*(lrc7u%#//:J');
define('LOGGED_IN_KEY', 'XM[+u47*ldjM91BBq1%-m58XW9xe*qsX#/Q%SYTo~]*tl110C|n8/7S_1_-05Aw3');
define('NONCE_KEY', 'lG~7KxA0u1+fqC:Ad|;d3H|6f*(m[ay)ahr20uB|T5aOq13cuv&c5BL-bt6W#/aA');
define('AUTH_SALT', 'Q@~2UsVA00foTt1-|Ye*bH2tg0j2#**p*914cv8TMN/2067FiqeQTJW[r6UTHHqk');
define('SECURE_AUTH_SALT', 'sywunLe[k-2Nf7F*ZYc4x-u]5CrKP#QR363roEKq8|lMrnYRl9X2%A46eR]mm:f9');
define('LOGGED_IN_SALT', 'uo6Z-3)w1_wL|[|68NwOp9K3wV;P(&33XhE-C0_s*:9r9L0H38Lf_SRMNdq72kD1');
define('NONCE_SALT', 'KS4n&c8%a00i5*D0_;T@lvX|9+Mj_;t%2;W#+]klNe8p4IrQ%h&1Ej8#6u[2CoGj');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '74FyGiKG_';


/* Add any custom values between this line and the "stop editing" line. */

define('WP_ALLOW_MULTISITE', true);
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
