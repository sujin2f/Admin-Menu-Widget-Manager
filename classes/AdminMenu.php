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

class AdminMenu {
	private $AdminMenu = array();

	private $data_menu_manager = array();
	private $data_widget_manager = array();

	private $all_menu = array();
	private $all_sub_menu = array();

	private $all_widget = array();

	private $option_key_menu = 'EVNSCO-menus';
	private $option_key_widget = 'EVNSCO-widgets';

	function __construct() {
		include_once( EVNSCO_PLUGIN_DIR . 'classes/wp_express/autoload.php' );

		if ( !empty( $_POST['mode'] ) && $_POST['mode'] == 'EVNSCO-menu' )
			add_action( 'admin_init', array( $this, 'SaveMenu' ) );

		if ( !empty( $_POST['mode'] ) && $_POST['mode'] == 'EVNSCO-widget' )
			add_action( 'admin_init', array( $this, 'SaveWidget' ) );

		add_action( 'admin_menu', array( $this, 'PrintPostTypeJsVars' ) );
		add_action( 'admin_menu', array( $this, 'GetData' ) );
		add_action( 'admin_menu', array( $this, 'EditMenu' ), 30000 );
		add_action( 'widgets_admin_page', array( $this, 'EditWidget' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'EnqueueToggleScript' ) );

		$this->SetMenuManager();
		$this->SetWidgetManager();
		$this->SetPostTypeToggle();

		if ( is_multisite() ) {
			$this->option_key_menu .= '-' . get_current_blog_id();
			$this->option_key_widget .= '-' . get_current_blog_id();
		}
	}

	// Menu Settings
	private function SetMenuManager() {
		$this->AdminMenu[ 'menu' ] = new \WE\AdminPage( 'Admin Menu Manager' );

		$this->AdminMenu[ 'menu' ]->position = 'Appearance';
		$this->AdminMenu[ 'menu' ]->template = array( $this, 'TemplateMenuManager' );

		$this->AdminMenu[ 'menu' ]->style = EVNSCO_PLUGIN_URL . 'assets/css/menu.css';
		$this->AdminMenu[ 'menu' ]->script = EVNSCO_PLUGIN_URL . 'assets/scripts/min/menu-min.js';
	}
	private function SetWidgetManager() {
		$this->AdminMenu[ 'widget' ] = new \WE\AdminPage( 'Widget Manager' );

		$this->AdminMenu[ 'widget' ]->position = 'Appearance';
		$this->AdminMenu[ 'widget' ]->template = array( $this, 'TemplateWidgetManager' );

		$this->AdminMenu[ 'widget' ]->style = EVNSCO_PLUGIN_URL . 'assets/css/widget.css';
	}
	private function SetPostTypeToggle() {
		$this->AdminMenu[ 'posttype' ] = new \WE\AdminPage( 'Show Posts Only' );
		$this->AdminMenu[ 'posttype' ]->position = 999999999999999999;
	}

	// Menu Manager
	public function TemplateMenuManager() {
		global $menu, $submenu;

		if ( !$this->data_menu_manager )
			$this->data_menu_manager = array( 'menu' => array(), 'submenu' => array() );

		include_once( EVNSCO_PLUGIN_DIR . 'templates/menu_manager.php' );
		include_once( EVNSCO_PLUGIN_DIR . 'templates/donation.php' );
	}
	private function GetMenuItemListVars( $menu_item ) {
		$menu_id = $menu_item[2];
		$name = preg_replace( '/ <(.*)$/im', '', $menu_item[0] );
		$checked = ( empty( $this->data_menu_manager[ 'menu' ][ $menu_id ] ) ) ? 'checked="checked"' : '';
		$li_class = ( !empty( $this->all_sub_menu[ $menu_id ] ) ) ? '' : 'no-submenu';

		return compact( 'menu_id', 'name', 'checked', 'li_class' );
	}
	private function GetSubMenuItemListVars( $menu_id, $sub_menu_item ) {
		$sub_id = $sub_menu_item[2];
		$name = preg_replace( '/ <(.*)$/im', '', $sub_menu_item[0] );
		$checked = ( empty( $this->data_menu_manager[ 'submenu' ][ $menu_id ][ $sub_id ] ) ) ? 'checked="checked"' : '';

		return compact( 'sub_id', 'name', 'checked' );
	}
	public function SaveMenu() {
		$P_AllMenu = $_POST[ 'AllMenu' ];
		$P_AllSubMenu = $_POST[ 'AllSubMenu' ];

		foreach( $_POST[ 'AllMenu' ] as $menu => $value ) {
			if ( !empty( $_POST[ 'MenuItem' ][ $menu ] ) || $menu === 'themes.php' )
				unset( $P_AllMenu[ $menu ] );
		}

		foreach( $_POST[ 'AllSubMenu' ] as $menu => $value1 ) {
			foreach( $value1 as $submenu => $value2 ) {
				if ( !empty( $_POST[ 'SubMenuItem' ][ $menu ][ $submenu ] ) || $submenu === 'admin-menu-manager' )
					unset( $P_AllSubMenu[ $menu ][ $submenu ] );
			}
		}

		update_user_meta( get_current_user_id(), $this->option_key_menu, array( 'menu' => $P_AllMenu, 'submenu' => $P_AllSubMenu ) );

		$this->RefreshScreen();
	}

	// Widget Manager
	public function TemplateWidgetManager() {
		include_once( EVNSCO_PLUGIN_DIR . 'templates/widget_manager.php' );
		include_once( EVNSCO_PLUGIN_DIR . 'templates/donation.php' );
	}
	public function SaveWidget() {
		$P_AllWidgets = $_POST[ 'AllWidgets' ];

		foreach( $_POST[ 'AllWidgets' ] as $widget => $value ) {
			if ( !empty( $_POST[ 'WidgetItem' ][ $widget ] ) )
				unset( $P_AllWidgets[ $widget ] );
		}

		update_user_meta( get_current_user_id(), $this->option_key_widget, $P_AllWidgets );

		$this->RefreshScreen();
	}

	public function GetData() {
		// Menu Data
		global $menu, $submenu;

		$this->data_menu_manager = get_user_meta( get_current_user_id(), $this->option_key_menu, true );
		$this->all_menu = $menu;
		$this->all_sub_menu = $submenu;

		// Widget Data
		global $wp_widget_factory;

		$this->data_widget_manager = get_user_meta( get_current_user_id(), $this->option_key_widget, true );
		$this->all_widget = $wp_widget_factory;
	}

	// Make Menu/Widget Visible or not
	public function EditMenu() {
		global $menu, $submenu;

		foreach( $this->all_menu as $key => $menu_item ) {
			if ( array_key_exists( $menu_item[2], $this->data_menu_manager[ 'menu' ] ) )
				unset( $menu[ $key ] );
		}

		foreach( $this->all_sub_menu as $menu_key => $menu_item ) {
			foreach( $menu_item as $sub_menu_key => $sub_menu_item ) {
				if ( array_key_exists( $sub_menu_item[2], $this->data_menu_manager[ 'submenu' ][ $menu_key ] ) )
					unset( $submenu[ $menu_key ][ $sub_menu_key ] );
			}
		}
	}
	public function EditWidget() {
		echo '<style>';

		foreach( $this->data_widget_manager as $widget => $value ) {
			printf( '#widgets-left .widgets-holder-wrap div[id*="_%s"].widget { display:none }', $widget );
		}

		echo '</style>';
	}

	// Toggler
	public function EnqueueToggleScript() {
		wp_enqueue_script( 'posttype-toggler', EVNSCO_PLUGIN_URL . 'assets/scripts/min/posttype-toggle-min.js', array( 'jquery' ) );
	}
	public function PrintPostTypeJsVars() {
		$posttypes = "'" . implode( "', '", get_post_types() ) . "'";

		?>
		<script>
			var toggle_data_posttypes = [<?php echo $posttypes ?>];
		</script>
		<?php
	}


	private function RefreshScreen() {
		printf( '<meta http-equiv="refresh" content="0; url=%s">', $_SERVER['HTTP_REFERER'] );
		printf( '<script>window.location="%s"</script>', $_SERVER['HTTP_REFERER'] );
		die;
	}
}

