<?php
/**
 * Initializing
 *
 * @package	Admin Menu & Widget Manager
 * @author	Sujin 수진 Choi
 * @version 3.0.0
 */

namespace EVNSCO;

if ( !defined( "ABSPATH" ) ) {
	header( "Status: 403 Forbidden" );
	header( "HTTP/1.1 403 Forbidden" );
	exit();
}

class Init {
	private $AdminMenu;

	function __construct() {
		if ( !is_admin() )
			return;

		$this->AdminMenu = new AdminMenu();
	}
}

