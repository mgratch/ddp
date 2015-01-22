<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'downtowndetroit_wp');

/** MySQL database username */
define('DB_USER', '1025602');

/** MySQL database password */
define('DB_PASSWORD', '5tNQFyjE');

/** MySQL hostname */
define('DB_HOST', 'db150c.pair.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '>U;PX}W|z96_D4Ij-hdsuL000N=dcdsk0j,Li{Mw-g| HJw!g<,.uMp(`*BP`_C5');
define('SECURE_AUTH_KEY',  'A->-JKc{+/T)<| bQ>?v,-^uEcRp6zZmgnR+b/2EMc>g_7G:_}F[SyU5E9Y]>W e');
define('LOGGED_IN_KEY',    'A#zi#fL%k=3 <%X%v<mer=<|1n!?.:Nwkdn]x)>EX5~m;3O)(4O)a=< YnhP957-');
define('NONCE_KEY',        'Tj5Y|kag9CZOp;nX_2H*]Y}XAy8`vvk+q52|d6ggic}0*N~i+tO]xB{J~&=v&v17');
define('AUTH_SALT',        'SYqzda^S&dQp$|{%Pf~]^F&=#|MJJ%:xX+%XVEO#2(dSEB+6b87I0+T+}XLb{z7/');
define('SECURE_AUTH_SALT', '~{:JE<L3YZ5H)Ccs~`?3Cu6=M1|n,`zF}:jN 7}p<A]noidwyv;k7Mi&*&M#3TjS');
define('LOGGED_IN_SALT',   'H,H!5Ae_a=-$Lxotun[F$(:D+8uKZeZ(0e:.<N;Uh.^p.0-ol?oVZTk=m?iI7t3x');
define('NONCE_SALT',       's/>X$sb7dw^!$V,PtGt-Jg^%Ng~>p1R3|vHtv<u!8:#Qx2b$L(2Db#na:tp|,3+/');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ddp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
