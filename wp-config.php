<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

include_once __DIR__ . '/Dotenv.php';
Dotenv::load(__DIR__);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', $_ENV['DB_NAME']);

/** MySQL database username */
define('DB_USER', $_ENV['DB_USER']);

/** MySQL database password */
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

/** MySQL hostname */
define('DB_HOST', $_ENV['DB_HOST']);

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
define('AUTH_KEY', '$v@;aWml0&y9u,(&D-@L`I>:qP?Y:Awna#^C+8;cT}`y!szFd3sksv-r;;6(1}i?');
define('SECURE_AUTH_KEY', 'R7Ik^v^0cSEq?y?W-WT*>m1^O]sgnl:mT_2[Em70k>x8$6*P[lsix4;`}T?:+Xuu');
define('LOGGED_IN_KEY', '+hAVe}D|&0KE|57p&&jF5dy3lp(DsJ0k|.wqLd`uLUB!}r|;;;D6rEPptwL>`3R.');
define('NONCE_KEY', 'xL)n;]]+p,O(bFT$1z3]w!b=k7Clas!J%<rYHPsH]E)6Kw&;>9$Qwrga:+mUdb-u');
define('AUTH_SALT', 'ZW|U_&SqI3YeSSiz?/&U|2/.LHb|]NE D<l6,@b!}#/_-9#@8+Axm6s3:`+14c$a');
define('SECURE_AUTH_SALT', '+kZ5=-k(cYW]sk.J{OxC.B3[lPjY28EHwfxmC$~oY5R=fZnphSc-q#-vM~^Tx6r?');
define('LOGGED_IN_SALT', 'D  :xNI~=O&YP+hUo|y`x::<L3]uyhRyq4;@]Db}c|QN^da^6C6PD)k4|fS0$nD>');
define('NONCE_SALT', '29{z06P$Pu#L;C_O@T20AczWGrn.H_|?wi;vJL<X-8U8W0)ihw,rKb~o<234f2x;');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = $_ENV['TABLE_PREFIX'];

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */

$debug = false;

if ($_ENV['DEBUG'] == 'true') {
    $debug = true;
}

define('WP_DEBUG', $debug);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
