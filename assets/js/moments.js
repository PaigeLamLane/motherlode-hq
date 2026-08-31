( function ( global ) {
	'use strict';

	var Atelier = {};

	Atelier.open = function ( config ) {
		var root = config.root;
		if ( ! root ) { return null; }

		var steps  = Array.prototype.slice.call( root.querySelectorAll( config.steps || '.moment' ) );
		var result = config.result ? root.querySelector( config.result ) : null;
		var count  = config.count ? root.querySelector( config.count ) : null;
		var at     = 0;

		function said() {
			var out = {};
			root.querySelectorAll( '[data-name]' ).forEach( function ( el ) {
				var key = el.dataset.name;
				if ( el.classList.contains( 'pick' ) ) {
					if ( el.getAttribute( 'aria-pressed' ) === 'true' ) { out[ key ] = el.dataset.value || el.textContent.trim(); }
					return;
				}
				var v = ( el.value || '' ).trim();
				if ( v ) { out[ key ] = v; }
			} );
			return out;
		}

		var mine = '';

		function draw() {
			if ( ! result || ! config.compose ) { return; }
			if ( result.dataset.touched === 'yes' ) { return; }   // theirs now, never ours again

			if ( '' !== result.value.trim() && result.value !== mine ) {
				result.dataset.touched = 'yes';
				return;
			}

			mine = config.compose( said() );
			result.value = mine;
		}

		function show( n ) {
			at = Math.max( 0, Math.min( steps.length - 1, n ) );
			steps.forEach( function ( s, i ) { s.classList.toggle( 'is-here', i === at ); } );
			if ( count ) { count.textContent = 'Moment ' + ( at + 1 ) + ' of ' + steps.length; }
			if ( at === steps.length - 1 ) { draw(); }
			steps[ at ].scrollIntoView( { block: 'start', behavior: 'smooth' } );
		}

		root.addEventListener( 'click', function ( e ) {
			var pick = e.target.closest( '.pick' );
			if ( pick ) {
				Array.prototype.forEach.call( pick.parentElement.querySelectorAll( '.pick' ), function ( p ) {
					p.setAttribute( 'aria-pressed', String( p === pick ) );
					p.classList.toggle( 'is-chosen', p === pick );
				} );
				return;
			}
			if ( e.target.closest( '[data-next]' ) ) { show( at + 1 ); }
			if ( e.target.closest( '[data-back]' ) ) { show( at - 1 ); }
		} );

		if ( result ) {
			result.addEventListener( 'input', function () { this.dataset.touched = 'yes'; } );
		}

		show( 0 );

		return {
			said: said,
			redraw: draw,
			go: show,
			at: function () { return at; }
		};
	};

	Atelier.shrink = function ( file, opts, done ) {
		opts = opts || {};
		var long = opts.long || 1600;
		var good = opts.quality || 0.72;

		var reader = new FileReader();
		reader.onerror = function () { done( null, 0 ); };
		reader.onload = function () {
			var img = new Image();
			img.onerror = function () { done( null, 0 ); };
			img.onload = function () {
				var w = img.width, h = img.height;
				if ( w > h && w > long ) { h = Math.round( h * long / w ); w = long; }
				else if ( h >= w && h > long ) { w = Math.round( w * long / h ); h = long; }

				var c = document.createElement( 'canvas' );
				c.width = w; c.height = h;
				c.getContext( '2d' ).drawImage( img, 0, 0, w, h );

				var url = c.toDataURL( 'image/jpeg', good );
				done( url, Math.round( url.length * 0.75 / 1024 ) );
			};
			img.src = reader.result;
		};
		reader.readAsDataURL( file );
	};

	global.Atelier = Atelier;
}( window ) );
