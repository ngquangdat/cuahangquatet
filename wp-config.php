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
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/uikibv1ieopw/public_html/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'cuahangquatet' );

/** MySQL database username */
define( 'DB_USER', 'cuahangquatet' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Nguyenquangdat13@' );

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
define( 'AUTH_KEY',         'EyQvw.fJ)q8&*;;j] @:i<b==UDV5Mj|30PMEk~rkX$QeEnwN)]Sd564hTwZ]bP3' );
define( 'SECURE_AUTH_KEY',  'OaM[i)vM<GBR5tA0TnStBDY~5R?ZwP+rzlF7o>~Dn<y3t|nM)Cvp5ZAe Zheh.P$' );
define( 'LOGGED_IN_KEY',    '@5|?tjSeMQEQ1081yq-Q,p<bI+yBS0[>] i)-&TkFkI%-Q9F.3t!u8Yqa@WLs!aB' );
define( 'NONCE_KEY',        'r,YsjWBh)=q5(c`B={l#-|yLv.]&# C!5*UxemZLRu< w8U8W1kvJg D#r_WHfsj' );
define( 'AUTH_SALT',        ',Nkvc~gnn;k9]knYk*&vd~1%c@V(iu5H(BF5<CjZ>]upe##hZLy0_c/PTo3^]#a_' );
define( 'SECURE_AUTH_SALT', 'I(vR&kIsd{,^k):_j.4-*FZV=T5_u)K:uwB)Le>)PhW7|5t);VTKo`=*R||ZE=`l' );
define( 'LOGGED_IN_SALT',   ':h[p(~MnW;Jf3KPI+1:iowe-0ATS^kQ6UxGDJ6Qe2[mn F[(SuBJc^g%#6>hCEDr' );
define( 'NONCE_SALT',       'G<}A3aYXeI3]fTLUz3Gr:a(XYHL6%idpg4a7I}[^m_N!5N,/#^kzu U~P|1p{I%4' );

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
