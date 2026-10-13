<?php
define( 'WP_CACHE', true );

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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '1h[5d9z+~qT&0vJCui)smbm$&f6s~|7H!>7[oQ30Vo[9hHb6bk`1{mb.lxSCXpG7' );
define( 'SECURE_AUTH_KEY',  '%a|XP}0J;Ebzj3]oW8r&3R<;{%xA.kHi|SZ}d3z$_+Wv~!dl0AXmOqeHj}^/hEty' );
define( 'LOGGED_IN_KEY',    '5gGXfS{`?Q6jfu$P8/AX?~cEPo.EYla<F?&%[||]4P;rWsR|d-@Y|{%PQ jCY*)C' );
define( 'NONCE_KEY',        '-;@+XD]PPAodO?I6x1=1SSIxEl)*tz@HUF9sd~8Y?VVH*h!<mo6Fx{Ueyu,>@0JZ' );
define( 'AUTH_SALT',        '#[pC>8D>}V. --|@l8qQ+vOe%-6F{_OSK,v*Fq((>v`9#(hpnq}/Sd2z%&*6p9L5' );
define( 'SECURE_AUTH_SALT', 'KR6.OAO4,0/TK]ZEtsQ<[Y%$(npv~D|Y9y+5j~JBnQW@cu$Ktl+/oa&}CTT/yo[F' );
define( 'LOGGED_IN_SALT',   '+tmDG|2y:OLLVijUseA:3JiX?r[:S/`w<+^FkPMt=~X)+bjMurT94A.$o%lyA G.' );
define( 'NONCE_SALT',       'Wz>EgpcCSKak}O#Dwb76Oxi[!f1M}iyby{cUa-~$5eLObbzpmBUR0/0xp3}2GdvN' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
