/**
 * SVGEdit extension: add 'Edit drawing' popup button for inline image usages (experimental)
 *
 * @param $
 * @param mw
 * @copyright 2011 Brion Vibber <brion@pobox.com>
 */

( function ( $, mw ) {

	$( () => {
	// We probably should check http://www.w3.org/TR/SVG11/feature#SVG-dynamic
	// but Firefox is missing a couple random subfeatures.
	//
	// Chrome, Safari, Opera, and IE 9 preview all return true for it!
	//
		if ( !document.implementation.hasFeature( 'http://www.w3.org/TR/SVG11/feature#Shape', '1.1' ) ) {
			return;
		}
		const trigger = function ( link ) {
		// hackkkkkkk
			const url = $( link ).attr( 'href' ),
				match = url.match( /\/[^?\/:]+:([^?\/]+)(?:\?|$)/ ),
				title = match[ 1 ];
			mw.svgedit.open( {
				filename: title,
				replace: link,
				onclose: function ( filename ) {
					if ( filename ) {
					// Saved! Refresh parent window...
						window.location.reload( true );
					}
				},
				leaveopen: true // Our reload will get rid of the UI.
			} );
		};

		function setupImage( link ) {
			const button = $( '<button>' )
				.text( mw.msg( 'svgedit-editbutton-edit' ) )
				.on( 'click', () => {
					trigger( link );
				} );
			$( link ).after( button );
		}

		$( 'a.image' ).each( function () {
			setupImage( this );
		} );
	} );

}( jQuery, mediaWiki ) );
