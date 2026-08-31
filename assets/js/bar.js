( function () {
	'use strict';
	var b = document.querySelector( '.bar-burger' );
	var m = document.getElementById( 'bar-menu' );
	if ( ! b || ! m ) { return; }

	function set( open ) {
		b.setAttribute( 'aria-expanded', String( open ) );
		m.hidden = ! open;
		document.querySelector( '.bar' ).classList.toggle( 'bar--open', open );
	}

	b.addEventListener( 'click', function () {
		set( b.getAttribute( 'aria-expanded' ) !== 'true' );
	} );

	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key ) { set( false ); }
	} );

	document.addEventListener( 'click', function ( e ) {
		if ( ! e.target.closest( '.bar' ) ) { set( false ); }
	} );
}() );
