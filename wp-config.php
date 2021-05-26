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
define( 'DB_PASSWORD', 'My_own_wordpress' );

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
define( 'AUTH_KEY',         '7- .;;D%IqJf<98`@~p7oIj8Mk6=Tlu+~C*>lLu3Cyj^[MXL W)lV+wfcLC};pdq' );
define( 'SECURE_AUTH_KEY',  'x`h`s$77ue7epf&B^pUELPjOt~X(p2H<!EB){jem|:#C9Ik/GQ.ZkAt@N/&oN+M,' );
define( 'LOGGED_IN_KEY',    'ZWUz2@ou,?^;%MaoQ7C|hLb4(0q:V4Toc~%U+X~p,hh!162Hjmcb ukk-R{he uy' );
define( 'NONCE_KEY',        '* W~dNl,xZXw~|#}-:/t{=?B:y91#-]Yb#g{G:Ag<Q<B9-2,~NK?bm p/hc,/pl/' );
define( 'AUTH_SALT',        'P?)+u`7@vMD-e#:(RU MDcwyBop1L(~c-v+-a9NCwBP0Jj*R2@=~  LrcJf)U^ )' );
define( 'SECURE_AUTH_SALT', 'UFzsmhUk]vcB|Jz)thmqc0C!1uT]Tc_p,=t`^bB!gh Nh^IWehPRPt5/s!<qQ`Oj' );
define( 'LOGGED_IN_SALT',   '|}*&cW8==M39V{jle&zm5/hx9Ao,RzRbbVoeX5|8q d:!xg>-neDdA#Ek@)8DqV#' );
define( 'NONCE_SALT',       'zUeo`ogi*f8na8(0m3dp.)[,]8&XQZws}LStC)w)^P%N4&cYo/.#sXrrAJ*g)bot' );

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
