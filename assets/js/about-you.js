( function () {
	'use strict';

	var root = document.getElementById( 'about-you' );

	if ( ! root || ! window.Atelier ) {
		return;
	}

	function one( said, key, own ) {
		var chose = ( said[ key ] || '' ).toString().trim();
		var mine  = ( said[ own ] || '' ).toString().trim();

		if ( mine ) { return mine; }

		return chose;
	}

	Atelier.open( {
		root:  root,
		steps: '.moment',
		result: '#about-letter',
		compose: function ( said ) {
			var lines = [];

			var who = one( said, 'who', 'whoOwn' );
			if ( who ) { lines.push( who + '.' ); }

			var place = one( said, 'place', 'placeOwn' );
			if ( place ) { lines.push( 'Here you will find ' + place + '.' ); }

			var need = one( said, 'need', 'needOwn' );
			if ( need ) { lines.push( 'What I usually need a hand with: ' + need + '.' ); }

			var pay = one( said, 'pay', 'payOwn' );
			if ( pay ) { lines.push( 'I pay ' + pay + '.' ); }

			var mine = ( said.ownWords || '' ).toString().trim();
			if ( mine ) { lines.push( mine ); }

			return lines.join( '\n\n' );
		}
	} );

	var keep = document.getElementById( 'about-keep' );
	var box  = document.getElementById( 'about-letter' );

	if ( ! keep || ! box ) { return; }

	keep.addEventListener( 'click', function () {
		keep.disabled = true;

		var body = new FormData();
		body.append( 'action', 'localilly_about_you' );
		body.append( 'localilly_about_you', root.getAttribute( 'data-nonce' ) );
		body.append( 'about', box.value );

		fetch( window.localillyAbout ? window.localillyAbout.where : '', {
			method: 'POST',
			credentials: 'same-origin',
			body: body
		} ).then( function ( r ) {
			return r.json();
		} ).then( function ( back ) {
			keep.disabled = false;
			keep.textContent = back && back.success ? 'Kept' : 'Press It Once More';
		} ).catch( function () {
			keep.disabled = false;
			keep.textContent = 'Press It Once More';
		} );
	} );
} )();
