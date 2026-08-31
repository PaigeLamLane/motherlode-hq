( function () {
	'use strict';

	var root = document.getElementById( 'atelier' );
	if ( ! root || ! window.Atelier ) { return; }

	var name = root.dataset.name || 'Zac';
	var picture = null;

	function compose( said ) {
		var doing = said.doingOwn || said.doing || '';
		var when  = said.whenOwn || said.when || '';
		var lines = [ ( 'them' === name ? 'Hello —' : 'Hi ' + name + ' —' ), '' ];

		if ( doing ) {
			var here = said.street ? ' at my place on ' + said.street : '';
			if ( said.suburb ) { here += ( here ? ', ' : ' in ' ) + said.suburb; }
			lines.push( 'I am after somebody for ' + doing.toLowerCase() + here + '.' );
		}

		if ( when )    { lines.push( '', 'When    ' + when ); }
		if ( picture ) { lines.push( 'Picture  attached, so you can see it' ); }
		if ( said.extra ) { lines.push( '', said.extra ); }

		lines.push( '', 'Let me know whether that suits you.' );
		if ( said.from ) { lines.push( '', '— ' + said.from ); }

		return lines.join( '\n' );
	}

	var atelier = window.Atelier.open( {
		root:    root,
		steps:   '.moment',
		compose: compose,
		result:  '#letter',
		count:   '#where'
	} );

	root.querySelector( '#from' ).addEventListener( 'input', atelier.redraw );

	var file = root.querySelector( '#picture' );
	var held = root.querySelector( '#held' );

	root.querySelector( '#pick-picture' ).addEventListener( 'click', function () { file.click(); } );

	file.addEventListener( 'change', function ( e ) {
		var chosen = e.target.files && e.target.files[ 0 ];
		if ( ! chosen ) { return; }
		window.Atelier.shrink( chosen, {}, function ( url, kb ) {
			if ( ! url ) {
				root.querySelector( '#where' ).textContent = 'That picture would rather stay put. Carry on without it.';
				return;
			}
			picture = url;
			root.querySelector( '#held-img' ).src = url;
			root.querySelector( '#held-size' ).textContent = 'Ready to travel — ' + kb + 'KB';
			held.hidden = false;
			root.querySelector( '#pick-picture' ).hidden = true;
			atelier.redraw();
		} );
	} );

	root.querySelector( '#drop-picture' ).addEventListener( 'click', function () {
		picture = null;
		file.value = '';
		held.hidden = true;
		root.querySelector( '#pick-picture' ).hidden = false;
		atelier.redraw();
	} );

	root.querySelector( '#send' ).addEventListener( 'click', function () {
		var letter = root.querySelector( '#letter' ).value.trim();
		var from   = ( root.querySelector( '#from' ).value || '' ).trim();
		var where  = root.querySelector( '#where' );

		if ( ! letter || ! from ) {
			where.textContent = 'Add your name, so ' + name + ' knows who is writing.';
			return;
		}

		this.disabled = true;
		this.textContent = 'On its way to ' + name;
		where.textContent = 'Sent. ' + name + ' has it, and he will write back to you here.';
	} );
}() );
