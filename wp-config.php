<?php
/**
 * AviaCourse - wp-config.php (container build).
 *
 * Everything secret comes from the environment, set in Coolify.
 * Nothing sensitive belongs in this repository.
 */

/* -------------------------------------------------------------- database -- */
define( 'DB_NAME',     getenv( 'WORDPRESS_DB_NAME' ) ?: 'aviacourse' );
define( 'DB_USER',     getenv( 'WORDPRESS_DB_USER' ) ?: 'aviacourse' );
define( 'DB_PASSWORD', getenv( 'WORDPRESS_DB_PASSWORD' ) ?: '' );
define( 'DB_HOST',     getenv( 'WORDPRESS_DB_HOST' ) ?: 'mariadb:3306' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );

/** Carried over from the old host. Changing this orphans every table. */
$table_prefix = 'wpct_';

/* ------------------------------------------------- keys and salts (env) --- */
foreach ( array(
	'AUTH_KEY',  'SECURE_AUTH_KEY',  'LOGGED_IN_KEY',  'NONCE_KEY',
	'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT',
) as $aviacourse_key ) {
	$aviacourse_val = getenv( 'WORDPRESS_' . $aviacourse_key );
	if ( $aviacourse_val ) {
		define( $aviacourse_key, $aviacourse_val );
	}
}
unset( $aviacourse_key, $aviacourse_val );

/* ------------------------------------------------------ behind Traefik --- */
/**
 * TLS terminates at the proxy, so PHP sees plain HTTP. Without this WordPress
 * builds http:// URLs and redirect-loops on every request.
 */
if ( ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] )
	&& 'https' === strtolower( trim( explode( ',', $_SERVER['HTTP_X_FORWARDED_PROTO'] )[0] ) ) ) {
	$_SERVER['HTTPS']       = 'on';
	$_SERVER['SERVER_PORT'] = 443;
}
if ( ! empty( $_SERVER['HTTP_X_FORWARDED_HOST'] ) ) {
	$_SERVER['HTTP_HOST'] = trim( explode( ',', $_SERVER['HTTP_X_FORWARDED_HOST'] )[0] );
}

/** Only for staging. In production leave unset and let the database decide. */
if ( getenv( 'WORDPRESS_HOME' ) ) {
	define( 'WP_HOME',    getenv( 'WORDPRESS_HOME' ) );
	define( 'WP_SITEURL', getenv( 'WORDPRESS_HOME' ) );
}

/* ----------------------------------------------------------- behaviour --- */
define( 'FS_METHOD', 'direct' );
define( 'WP_MEMORY_LIMIT',     '512M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );
define( 'DISALLOW_FILE_EDIT',  true );

/**
 * Plugins, languages and uploads sit on persistent volumes, so wp-admin can
 * install and update them exactly as before and the changes survive a deploy.
 * Core is the exception: it comes from the image, so pin it here and move it
 * by bumping the Dockerfile's FROM tag instead.
 */
define( 'WP_AUTO_UPDATE_CORE', false );

define( 'WP_DEBUG', filter_var( getenv( 'WORDPRESS_DEBUG' ) ?: 'false', FILTER_VALIDATE_BOOLEAN ) );
if ( WP_DEBUG ) {
	define( 'WP_DEBUG_LOG',     true );
	define( 'WP_DEBUG_DISPLAY', false );
}

/** Set true once the Coolify scheduled task for wp-cron.php exists. */
if ( filter_var( getenv( 'WORDPRESS_DISABLE_WP_CRON' ) ?: 'false', FILTER_VALIDATE_BOOLEAN ) ) {
	define( 'DISABLE_WP_CRON', true );
}

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
