<?php

/**
 * Enviroment bootstraping
 * Based on heroku addons
 */
function getEnvOr($key, $default = null) {
	$value = getenv($key);

	

	return !empty($value) ? $value : $default;
}



if (!empty(getenv('JAWSDB_URL')) && !defined('WP_CLI')):
	$url = parse_url(getenv('JAWSDB_URL'));
	putenv('DB_NAME='.substr($url['path'], 1));
	putenv('DB_USER='.$url['user']);
	putenv('DB_PASSWORD='.$url['pass']);
	putenv('DB_HOST='.$url['host']);
endif;

if (!empty(getenv('CLOUDCUBE_URL')) && !defined('WP_CLI')):
	$url = parse_url(getenv('CLOUDCUBE_URL'));
	$bucket = explode('.', $url['host'])[0];
	$path = $url['path'].'/'.$_SERVER['HTTP_HOST'];
	define('S3_UPLOADS_BUCKET', $bucket.$path);
	define('S3_UPLOADS_REGION', 'us-east-1');
	define('S3_UPLOADS_KEY', getenv('CLOUDCUBE_ACCESS_KEY_ID'));
	define('S3_UPLOADS_SECRET', getenv('CLOUDCUBE_SECRET_ACCESS_KEY'));
endif;

/**
 * Handle Heroku ssl
 */

define('FORCE_SSL_ADMIN', getEnvOr('FORCE_SSL_ADMIN', false));

if (
	defined('FORCE_SSL_ADMIN') &&
	isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
	strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false
):
	$_SERVER['HTTPS'] = 'on';
endif;

/**
 * Define contansts
 * to be used through out the app
 */



define('PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://');
define('HOST', count(explode('.', $_SERVER['HTTP_HOST'])) <= 2 ? 'www.'.$_SERVER['HTTP_HOST'] : $_SERVER['HTTP_HOST']); // Root domain replication
define('URL', PROTOCOL.HOST);


define('DB_CHARSET', getEnvOr('DB_CHARSET', 'utf8mb4'));
define('DB_COLLATE', getEnvOr('DB_COLLATE', ''));
define('DB_NAME', getEnvOr('DB_NAME', md5(HOST)));
define('DB_USER', getEnvOr('DB_USER', 'root'));
define('DB_PASSWORD', getEnvOr('DB_PASSWORD', ''));
define('DB_HOST', getEnvOr('DB_HOST', '127.0.0.1'));

define('AUTH_KEY', getEnvOr('AUTH_KEY', 'uKa(B9 slREej&K-gsUKvl=2R457a9`eZp0_Ib %H+TChCC/0V)$@s&C{ga}`6J`'));
define('SECURE_AUTH_KEY', getEnvOr('SECURE_AUTH_KEY', 'd@B;=}pf]x$(B]&,LL?oL3Ap;wsJI}wfgzjf9c$:r+R}en$^b$Nt]:Sk  (FJO4$'));
define('LOGGED_IN_KEY', getEnvOr('LOGGED_IN_KEY', 'YnZyQMK{iWF=c7-uwhu4T<M4FrDT][#H|[=Z_u0vWSJ+s^;3=9hNKvng~WQ#Z6NK'));
define('NONCE_KEY', getEnvOr('NONCE_KEY', 'YDao1D3lMdp.Aecj-ZU(@#NG$xodpI6)Q%T286J|CwC5-kJy>O#T}By9VZ3Y@q ,'));
define('AUTH_SALT', getEnvOr('AUTH_SALT', 'SuvxGYsr91F~aVx2XK!BLS9?4q48ODPY#1=*^44Z:%q2Sw(1 }3#5v4NQ(P6GZ.N'));
define('SECURE_AUTH_SALT', getEnvOr('SECURE_AUTH_SALT', 'eZ!^(BS:P$R&d/7PA9=4266JGz3:kSFEHlq1DOv!5*/0r(xDY}jp8;r2qeXo*[QC'));
define('LOGGED_IN_SALT', getEnvOr('LOGGED_IN_SALT', '-/iPx?1Uz:flP)-T2:@UZ~}cW32BoM}S_p;gfqF.ZI*bk!W,Pdy.d@m$<X{o:s@3'));
define('NONCE_SALT', getEnvOr('NONCE_SALT', ']c5oeTN0OF{Tif5a7@h<GY#N-(X/P?&z@4JqdmkD(EU n&aO6=<Qfcn^f7nHf*9`'));



/**
 * Dinamic database check
 * This would only work if you can create new
 * databases, check your mysql server and permissions
 *
 * When using this option DB_NAME should not be defined on
 * heroku env vars
 */

if (defined('DB_NAME') && DB_NAME === md5(HOST)):
	$connection = new PDO('mysql:host='.DB_HOST, DB_USER, DB_PASSWORD);
	$connection->query('CREATE DATABASE IF NOT EXISTS '.DB_NAME);
endif;

$table_prefix = 'wp_';



define( 'WP_DEBUG', false );
/**
 * Conditional plugin activation
 * Check if an external file system is required
 */

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

/**
 * Permalink default
 * Enables rest api
 */

if (!defined('WP_CLI')):
	global $wp_rewrite;

	if ($wp_rewrite->permalink_structure !== '/%postname%/'):
		$wp_rewrite->set_permalink_structure('/%postname%/');
		$wp_rewrite->flush_rules();
	endif;
endif;
