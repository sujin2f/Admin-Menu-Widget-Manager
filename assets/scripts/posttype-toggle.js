jQuery( document ).ready( function($) {
	var toggled = false;

	$( '#adminmenu #toplevel_page_show-posts-only' ).appendTo( "#adminmenu" ).css( 'clear', 'both' );

	$( '#adminmenu #toplevel_page_show-posts-only a' ).click( function(e) {
		e.preventDefault();

		if ( toggled ) {
			$( '#adminmenu > li' ).show();
			toggled = false;

		} else {
			$( '#adminmenu > li' ).each( function() {
				var attr_id = $(this).attr( 'id' );
				var text_included = false;

				if ( attr_id !== 'toplevel_page_show-posts-only' ) {
					toggle_data_posttypes.forEach( function( posttype ) {
						if ( attr_id && attr_id.includes( 'menu-' + posttype ) )
							text_included = true;
					});

					if ( !text_included ) {
						$(this).hide();
					}
				}
			});

			toggled = true;
		}
	});
});