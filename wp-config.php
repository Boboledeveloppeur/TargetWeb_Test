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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'TargetWeb_Test' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'x2 h]?XA/kg&>XPXkg~#0}ZtdX3v$Rz_1KrDPskO3+`FIz3LK}|)oYANHJh.l}2~' );
define( 'SECURE_AUTH_KEY',  'O|7Lq7VcD_`4NzL3_qVIW ero&P^F:;S2)^XS}}-eeac|t*qWEzPDlz?<%Ao08la' );
define( 'LOGGED_IN_KEY',    'qJ0TjbO_:3Z!w(B.r[Dig_(YuG5`}bo[;;L+d3`|@KT6&[D8KFg_*5dRG:nJC$V@' );
define( 'NONCE_KEY',        ')Zo;!A^0g]{-K.U<PYI+*N/h$;~w{?nA|k9LHV~ VtU6 VkRVj}3C7O/t[y]upw]' );
define( 'AUTH_SALT',        'I5xUc`Y[=44MdiS8SDOuqW]~K-=+`*4%Uz:zq4-)Q~nx6B1LBolTr!I[f;Lz^~/R' );
define( 'SECURE_AUTH_SALT', '4:$r5v,`L>F>t__k7dq2QKdI_![TQ(ZwI~<SyL5XplCQ#h7O>w5/qWdSk18i=~}%' );
define( 'LOGGED_IN_SALT',   '=qaSkrbUP?mM1PZf=<(`&}h+J|lr!y,ECpongKDB|0+AK+6szsUmPxv8LkX%FeqU' );
define( 'NONCE_SALT',       '=>8Jd#ATk=8*j8yAg!7xA?RN44QY),=<fyeX$&-hTB!Q*|MwC]s81?w5ztHz*4]G' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
