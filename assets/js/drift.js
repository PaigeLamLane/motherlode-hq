( function () {
	'use strict';

	if ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	var hero = document.querySelector( '.hero-plate.has-picture' );
	if ( ! hero ) {
		return;
	}

	var waiting = false;

	function drift() {
		waiting = false;

		var box = hero.getBoundingClientRect();

		if ( box.bottom < 0 || box.top > window.innerHeight ) {
			return;
		}

		hero.style.setProperty( '--drift', Math.round( box.top * -0.14 ) + 'px' );
	}

	function ask() {
		if ( ! waiting ) {
			waiting = true;
			window.requestAnimationFrame( drift );
		}
	}

	window.addEventListener( 'scroll', ask, { passive: true } );
	window.addEventListener( 'resize', ask, { passive: true } );
	drift();
}() );
