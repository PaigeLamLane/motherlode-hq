( function () {
	'use strict';

	var asit = document.getElementById( 'asit' );
	if ( ! asit ) { return; }

	var form = document.getElementById( 'steps' ) || document.querySelector( '.build-form' );

	function show( what, said ) {
		var el = asit.querySelector( '[data-asit="' + what + '"]' );
		if ( ! el ) { return; }
		el.textContent = said;
		el.classList.toggle( 'is-empty', ! said.trim() );
	}

	function watch( id, what ) {
		var el = document.getElementById( id )
			|| ( form && form.querySelector( '[name="' + id + '"]' ) )
			|| document.querySelector( '.build-form [name="' + id + '"]' )
			|| document.querySelector( 'form [name="' + id + '"]' );

		if ( ! el ) { return; }

		el.addEventListener( 'input', function () { show( what, this.value ); } );
	}

	[ [ 'name', 'name' ], [ 'line', 'line' ], [ 'suburb', 'suburb' ],
	  [ 'words', 'words' ], [ 'free', 'free' ] ].forEach( function ( pair ) {
		watch( pair[ 0 ], pair[ 1 ] );
	} );

	if ( form ) {
		form.addEventListener( 'change', function ( e ) {
			if ( ! e.target.matches( 'input[name="doing[]"]' ) ) { return; }
			var list = asit.querySelector( '[data-asit="doing"]' );
			if ( ! list ) { return; }
			list.innerHTML = '';
			form.querySelectorAll( 'input[name="doing[]"]:checked' ).forEach( function ( one ) {
				var li = document.createElement( 'li' );
				var said = one.closest( 'label' );
				said = said ? said.querySelector( 'span' ) : null;
				li.textContent = said ? said.textContent : one.value;
				list.appendChild( li );
			} );
		} );
	}

	var shots = document.getElementById( 'shots' );
	if ( ! shots || ! window.Atelier ) { return; }

	var MOST  = parseInt( shots.dataset.limit, 10 ) || 10;
	var LARGE = 400 * 1024;   // after shrinking, per picture

	var held = document.getElementById( 'shots-held' );
	var pick = document.getElementById( 'shot-in' );
	var kept = [];

	document.getElementById( 'shot-add' ).addEventListener( 'click', function () { pick.click(); } );

	function draw() {
		held.innerHTML = '';
		kept.forEach( function ( url, i ) {
			var li  = document.createElement( 'li' );
			var img = document.createElement( 'img' );
			img.src = url;
			img.alt = 'Work this young person has done';
			var off = document.createElement( 'button' );
			off.type = 'button';
			off.className = 'press small';
			off.textContent = 'Take It Off';
			off.addEventListener( 'click', function () { kept.splice( i, 1 ); draw(); } );
			li.appendChild( img );
			li.appendChild( off );
			held.appendChild( li );
		} );

		form.querySelectorAll( 'input[name="shots[]"]' ).forEach( function ( el ) { el.remove(); } );
		kept.forEach( function ( url ) {
			var f = document.createElement( 'input' );
			f.type = 'hidden';
			f.name = 'shots[]';
			f.value = url;
			form.appendChild( f );
		} );

		document.getElementById( 'shot-add' ).hidden = kept.length >= MOST;

		var on = asit.querySelector( '.asit-shots' );
		if ( on ) {
			on.innerHTML = '';
			kept.forEach( function ( url ) {
				var li = document.createElement( 'li' );
				var im = document.createElement( 'img' );
				im.src = url;
				im.alt = 'Work this young person has done';
				li.appendChild( im );
				on.appendChild( li );
			} );
		}
	}

	pick.addEventListener( 'change', function ( e ) {
		var files = Array.prototype.slice.call( e.target.files || [] );
		var room  = MOST - kept.length;

		files.slice( 0, room ).forEach( function ( file ) {
			window.Atelier.shrink( file, { long: 1400, quality: 0.7 }, function ( url, kb ) {
				if ( ! url || ( url.length * 0.75 ) > LARGE ) {
					var say = document.createElement( 'p' );
					say.className = 'ask-small';
					say.textContent = 'That one is too big to travel, even made small. Another picture of the same work would do it.';
					shots.appendChild( say );
					return;
				}
				kept.push( url );
				draw();
			} );
		} );

		pick.value = '';
	} );

	draw();
}() );
