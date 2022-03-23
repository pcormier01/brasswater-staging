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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'a776070125b36aa78b2f1ea30583b5c9d407a6188b72c4d4' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'UFSd6Zzp8vdX^e+`0z]-J`DbXZyRuNv.pMM~S16Lu{C.l8TFUuv#~=LAU(ctw2?2' );
define( 'SECURE_AUTH_KEY',  '9&$ZIsaa|Ze63ah`!2S*s`I<^ymuS=2+%zI-Y$J`4D;a/&Esf[~y-l=v>Lgn!B!`' );
define( 'LOGGED_IN_KEY',    'GD&9dA]FhxK8iy9/*>=q1)W:M;)9!RUH42W j[[O1@g)V28iXB5hROU~W37xz5l/' );
define( 'NONCE_KEY',        '7d5~A>Lg>J~{kA*v1]jn-vx<=z]+#V_CBI+w;{1JJ^&T?~UNQ)uW.u<[^lBBTf4O' );
define( 'AUTH_SALT',        'e7q]YkS--ZxR1~:(I@@#hW6sI$!5>nF>BBOgp?-AL+V}pAo/._NrgPi/C,<i|wjY' );
define( 'SECURE_AUTH_SALT', '[*e.b5rozCL~m}(@<u3~1xQ0KX4JjxR3uy?$f!PqG8d|]]q3 GZ`^jF6qV2I^5-+' );
define( 'LOGGED_IN_SALT',   'f)7?[Tf?1bbMP>J>dHBC(q@!3CwBR1.nE?j(gY|PEDxu,]O9FnEB]Z)q.#}I*K V' );
define( 'NONCE_SALT',       'p*m/A<%JO[e)9d(Bmwx]AM;5MbZN8]i|gvosMU_u?>6R$0>F*Jr7disf@f)5:kzG' );

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

define( 'WPCF7_VALIDATE_CONFIGURATION', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
