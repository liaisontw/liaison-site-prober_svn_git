<?php

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}


if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL; // WPCS: XSS ok.
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

// Load the WP_CLI library.
//require_once 'phar:///usr/local/bin/wp-cli.phar/vendor/autoload.php';
//require_once 'phar://wp-cli.phar/vendor/autoload.php';

// Prevent WP_CLI::error() from calling exit.  A WP_CLI\ExitException will be thrown instead allowing it to be caught during tests.
// $class_wp_cli_capture_exit = new \ReflectionProperty( 'WP_CLI', 'capture_exit' );
// $class_wp_cli_capture_exit->setAccessible( true );
// $class_wp_cli_capture_exit->setValue( true );

// Load the PHPUnit Polyfills library.

/*
$phpunit_polyfills_path = dirname(dirname(__FILE__)).'/vendor/yoast/phpunit-polyfills';

$_phpunit_polyfills_lib = $phpunit_polyfills_path . '/phpunitpolyfills-autoload.php';
if ( ! file_exists( $_phpunit_polyfills_lib ) ) {
	echo "Could not find $_phpunit_polyfills_lib, have you run `docker-compose up` in order to install Composer packages?" . PHP_EOL; // WPCS: XSS ok.
	exit( 1 );
}
require_once $_phpunit_polyfills_lib;
*/

/**
 * Manually load the plugin being tested.
 */

function _manually_load_plugin() {
	require dirname( __DIR__, 1 ) . '/rusty-inc-org-chart.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';






