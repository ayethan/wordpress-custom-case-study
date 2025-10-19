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
define( 'DB_NAME', 'case_study_db' );

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
define( 'AUTH_KEY',         'cc~Ef(0;$OWnD7B2m^p`rH-?SFvBwq HrCYZ6TLTS_GM{|?st)cd1y3ww5qD[Sm}' );
define( 'SECURE_AUTH_KEY',  ')Jz3rx85<_4+`0!/oe`a<*l+gu<sfEBL^cCR3]U)za(gA$==i/ !YE83Aiyb`~/m' );
define( 'LOGGED_IN_KEY',    'kip*`LH2<&)Pc5kWF<1wYV&p2J>cl15pj#=`[vF@4c>j dPpbkjx7H:eq[[z,!OH' );
define( 'NONCE_KEY',        '6Cka`WZ>H8D)pzHB&=4G&Cz#]:^gN%4!.#}R^I~rQ7)LX/q<m[E?jAo1H`O+f3X/' );
define( 'AUTH_SALT',        '?+@+d7w-}UNoT?1uzx-o?i`2i_lm2gpE3[dTdem28d?*7Zv)j1T3[WcMc?NS&)3Z' );
define( 'SECURE_AUTH_SALT', 'sB/L4ia{Bhj(,^P},{O6*N-|#`o/T8(U( P}!>b|e6_$mwk+&|LifF2mJDOn[r@/' );
define( 'LOGGED_IN_SALT',   'HfO%`=b/Of&nusk[=zLWqQR{-$&3k7y(tRGWc=<Ht-(|S*N|LkfAM`C{C*F:O5RD' );
define( 'NONCE_SALT',       'b`!jJV&dm*gU;`W?V-Y]CE5q8BR.pRm9y/R$P[Xs[56U))7u1-7VP)|&-*7G3d=O' );

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
