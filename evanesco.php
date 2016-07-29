<?php
/**
 * Plugin Name:		Admin Menu & Widget Manager
 * Plugin URI:		http://www.sujinc.com/
 * Description:		Manage Wordpress admin menu and widget
 * Version:				3.0.0
 * Author:				Sujin 수진 Choi
 * Author URI:		http://www.sujinc.com/
 * License:				GPLv2 or later
 * Text Domain:		evanesco
 */


if ( !defined( "ABSPATH" ) ) {
	header( "Status: 403 Forbidden" );
	header( "HTTP/1.1 403 Forbidden" );
	exit();
}

# Constants
if ( !defined( "EVNSCO_PLUGIN_NAME" ) ) {
	$basename = trim( dirname( plugin_basename( __FILE__ ) ), "/" );
	if ( !is_dir( WP_PLUGIN_DIR . "/" . $basename ) ) {
		$basename = explode( "/", $basename );
		$basename = array_pop( $basename );
	}

	define( "EVNSCO_PLUGIN_NAME", $basename );
}

if ( !defined( "EVNSCO_PLUGIN_FILE_NAME" ) )
	define( "EVNSCO_PLUGIN_FILE_NAME", basename(__FILE__) );

if ( !defined( "EVNSCO_TEXTDOMAIN" ) )
	define( "EVNSCO_TEXTDOMAIN", "EVNSCO" );

if ( !defined( "EVNSCO_PLUGIN_DIR" ) )
	define( "EVNSCO_PLUGIN_DIR", WP_PLUGIN_DIR . "/" . EVNSCO_PLUGIN_NAME . "/" );

if ( !defined( "EVNSCO_PLUGIN_URL" ) )
	define( "EVNSCO_PLUGIN_URL", WP_PLUGIN_URL . "/" . EVNSCO_PLUGIN_NAME . "/" );

# Initialize
include_once( EVNSCO_PLUGIN_DIR . "autoload.php");
new EVNSCO\Init();
