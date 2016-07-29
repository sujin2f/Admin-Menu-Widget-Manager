jQuery( document ).ready( function($) {
	// SubMenu Expander
	$( "form#EVNSCO-admin_menu > ul > li > span.dashicons" ).click( function() {
		if ( $(this).hasClass( 'dashicons-arrow-right' ) ) { // Open
			hideAllSubMenu();

			$(this).parent().children( 'ul' ).show();
			$(this).removeClass( 'dashicons-arrow-right' );
			$(this).addClass( 'dashicons-arrow-down' );
		} else { // Close All
			hideAllSubMenu();
		}
	});

	function hideAllSubMenu() {
		$( "form#EVNSCO-admin_menu > ul > li > ul" ).hide();
		$( "form#EVNSCO-admin_menu > ul > li > span.dashicons" ).removeClass( 'dashicons-arrow-down' );
		$( "form#EVNSCO-admin_menu > ul > li > span.dashicons" ).addClass( 'dashicons-arrow-right' );
	}
});