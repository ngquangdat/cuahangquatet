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
define( 'DB_NAME', 'cuahangquatet' );

/** MySQL database username */
define( 'DB_USER', 'cuahangquatet' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Nguyenquangdat13@' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

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
define( 'AUTH_KEY',         'R$SpSA/a_5%2U(TsxQ#L; /7}920)iI6L^3deEH`A}jj]Z?gef`nD9` WL5Hr:)8' );
define( 'SECURE_AUTH_KEY',  't+|2^rP3SqMpn)SkWxYy{FJD|%I>LMl4K,LVn1V#<51?XVUY{H??mkL=h3A:ET&1' );
define( 'LOGGED_IN_KEY',    '[]~CTx.D7HW~77.i8_v?6o(I^8/(cO AC*zu%s8*b*i`0+G>VvrQu~s&LP`7t0 y' );
define( 'NONCE_KEY',        'W}4lqs5 1wHc>=9._L]G_- # Y]mhYrlMnlHq]no03%^_:)qMvb-qPP!UPhEMSf2' );
define( 'AUTH_SALT',        ',@yLWFfONl!QEg##97=sV!iS/2;cyT/p{ZLWgpn!n$OP?$kR~`G*(c}8iFi*^E34' );
define( 'SECURE_AUTH_SALT', '=SXsG#-jg!vh;yN*1**Tr`YPy5&b}X<aA5^yKg7_+bpm?rUA#!X+T:,)yZ&2EGyf' );
define( 'LOGGED_IN_SALT',   ';AsVM(pbOYdr;wT@WN:.)*8%t&>~X(6ZCY}M1NV:h=<mK-Y{XM/+ja=QyHL?mM_i' );
define( 'NONCE_SALT',       '`13pr>*O&;fPL}|r=w^NuR(fYllaiT^|UygEIGy?3u-$}*r<=L5qIBiL~`.8;1Kc' );

/**#@-*/

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
