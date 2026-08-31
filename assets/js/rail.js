( function () {
	'use strict';

	var rail = document.querySelector( '.rail' );
	if ( ! rail ) { return; }

	var still = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	rail.classList.add( still ? 'rail--asked-to-be-still' : 'rail--travels' );

	if ( still ) {
		return;
	}

	var snap = rail.style.scrollSnapType;
	rail.style.scrollSnapType = 'none';

	var mine = true;    // whether the movement is still ours
	var seen = false;   // whether the rail is on screen
	var pass = 0;       // how many times it has been round
	var last = Date.now();

	var TICK  = 32;     // about thirty steps a second
	var SPEED = 0.026;  // pixels a millisecond — twenty-six a second, a reading pace

	var settle;

	function theirs() {
		mine = false;
		rail.classList.add( 'rail--theirs' );
		rail.classList.remove( 'rail--settled' );

		window.clearTimeout( settle );
		settle = window.setTimeout( function () {
			rail.classList.add( 'rail--settled' );
		}, 220 );
	}

	[ 'pointerdown', 'wheel', 'touchstart', 'keydown' ].forEach( function ( e ) {
		rail.addEventListener( e, theirs, { passive: true } );
	} );

	rail.addEventListener( 'scroll', function () {
		if ( mine ) { return; }
		window.clearTimeout( settle );
		settle = window.setTimeout( function () {
			rail.classList.add( 'rail--settled' );
		}, 220 );
	}, { passive: true } );

	seen = true;

	if ( window.IntersectionObserver ) {
		new IntersectionObserver( function ( rows ) {
			seen = rows[ 0 ].isIntersecting;
		}, { threshold: 0.01 } ).observe( rail );
	}

	function step() {
		var now = Date.now();
		var gap = now - last;
		last = now;

		if ( ! mine || ! seen ) { return; }
		if ( document.hidden ) { return; }
		if ( gap > 400 ) { return; }   // a tab coming back should never lurch

		var end = rail.scrollWidth - rail.clientWidth;
		if ( end <= 0 ) { return; }

		rail.scrollLeft += gap * SPEED;

		if ( rail.scrollLeft >= end - 1 ) {
			rail.scrollLeft = 0;
			pass += 1;
			rail.classList.toggle( 'rail--mint', 1 === pass % 2 );
		}
	}

	window.setInterval( step, TICK );
}() );
