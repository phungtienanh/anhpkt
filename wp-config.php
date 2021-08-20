<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', '1' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '.@l~+labaG0pe/|Mu3/(,JO_:XVo7L S1jjX3beQ{c5V>=@KqKi-|9sSZ,iFUM4d' );
define( 'SECURE_AUTH_KEY',  '*5-2;/4n;ELPobQ=OuJkGVrUJ/[}S(QE}tB0h!%#FZHxo=l<kF9VJ qJ%q? *%x6' );
define( 'LOGGED_IN_KEY',    '@sM<GbPEu#T[7R<j<YKRg+EeZWR;XEvW.O%X68{[ P}VT}oo,[-%!.Mv*Rt!uCAn' );
define( 'NONCE_KEY',        '8[{?(Nv0>Aita#,.L#&NK!;K+8PJt/b $*1bnR[qz%AH {Op0@P 6$6=ZKI&Y(kp' );
define( 'AUTH_SALT',        'pGS<{A^lT6KKeFt3N2Kj]2~/y-V[]1$;7Guu*nWD`8TR{xZsMKy!EqErK,j}BbFn' );
define( 'SECURE_AUTH_SALT', 'lXj8p.qjb}]ojh4C[g`q6DS 1XhK/I}9DrXfGJi{{{W+MUQ3~cp4,[+W1E$l[)xP' );
define( 'LOGGED_IN_SALT',   '-$+++~sxjTRo=A+}J[==m.|.eap*.Q<spg!A4H:rb|3-V|^O9OI~,g>F>*AbI{Z)' );
define( 'NONCE_SALT',       '@q=u[F8_-hapol*muWB_)3TY?Wy(/_ TiAZ?#(Z6` ezo]ZWm,o+SrH-RSeF;kVD' );
define('JWT_AUTH_SECRET_KEY', '-$+++~sxjTRo=A+}J[==m.|.eap*.Q<spg!A4H:rb|3-V|^O9OI~,g>F>*AbI{Z');

/**#@-*/

define('JWT_AUTH_CORS_ENABLE', true);

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
