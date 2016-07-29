<?php
/**
 *
 * WP Express Autoloader & Redirect
 *
 * @author	Sujin 수진 Choi
 * @package	wp-express
 * @version	4.0.0
 * @website	http://sujinc.com
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice
 *
 */

if ( !function_exists( 'EVNSCO' ) ) {
	function EVNSCO() {
		spl_autoload_register( function( $className ) {
			$namespace = 'EVNSCO\\';
			if ( stripos( $className, $namespace ) === false ) {
		        	return;
			}

			$sourceDir = __DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR;
			$fileName  = str_replace( [ $namespace, '\\' ], [ $sourceDir, DIRECTORY_SEPARATOR ], $className ) . '.php';

			if ( is_readable( $fileName ) ) {
				include $fileName;
			}
		});
	}

	EVNSCO();
}