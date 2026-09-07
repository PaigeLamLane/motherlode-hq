( function () {
	'use strict';

	var els = document.querySelectorAll( '.arrival' );
	var el = els[0];
	if ( ! el ) {
		return;
	}

	var PLACES = {
		'Australia/Melbourne': { name: 'Melbourne', lat: -37.81, lon: 144.96 },
		'Australia/Sydney':    { name: 'Sydney',    lat: -33.87, lon: 151.21 },
		'Australia/Brisbane':  { name: 'Brisbane',  lat: -27.47, lon: 153.03 },
		'Australia/Adelaide':  { name: 'Adelaide',  lat: -34.93, lon: 138.60 },
		'Australia/Perth':     { name: 'Perth',     lat: -31.95, lon: 115.86 },
		'Australia/Hobart':    { name: 'Hobart',    lat: -42.88, lon: 147.33 },
		'Australia/Darwin':    { name: 'Darwin',    lat: -12.46, lon: 130.84 },
		'Australia/Canberra':  { name: 'Canberra',  lat: -35.28, lon: 149.13 }
	};

	var now = new Date();
	var hour = now.getHours();
	var day = now.getDay();
	var weekend = ( 0 === day || 6 === day );
	var DAYS = [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ];

	var zone = '';
	try { zone = Intl.DateTimeFormat().resolvedOptions().timeZone || ''; } catch ( e ) { zone = ''; }
	var place = PLACES[ zone ] || null;

	function partOfDay() {
		if ( hour < 5 ) { return 'night'; }
		if ( hour < 12 ) { return 'morning'; }
		if ( hour < 17 ) { return 'afternoon'; }
		if ( hour < 21 ) { return 'evening'; }
		return 'night';
	}

	function isLate() { return ( hour >= 21 || hour < 5 ); }

	function clock() {
		var h = now.getHours() % 12;
		if ( 0 === h ) { h = 12; }
		var m = now.getMinutes();
		return h + '.' + ( m < 10 ? '0' + m : m ) + ( now.getHours() < 12 ? 'am' : 'pm' );
	}

	function opening( weather ) {
		var when = 'It is ' + clock() + ' on a ' + DAYS[ day ] + ' ' + partOfDay();
		var here = place ? ' in ' + place.name : '';

		if ( ! weather ) { return when + here + '.'; }

		var how = feels( weather.temp );
		var was = how ? 'a ' + how + ' ' + weather.temp + ' degrees' : weather.temp + ' degrees';

		return 'It is ' + clock() + ' on a ' + DAYS[ day ] + ' ' + partOfDay() + here
			+ ', and it is ' + was + '.';
	}

	function bank() {
		if ( isLate() ) {
			return [
				'A professional near you could start first thing tomorrow.',
				'Worth lining up real help for the week ahead.',
				'Somebody local has an hour free this weekend.'
			];
		}

		var out = [
			'Real expertise, closer than you’d think.',
			'Two hours could be all it takes.',
			'Somebody local is free this week.'
		];

		if ( weekend ) {
			out.push( 'A good weekend to get ahead on it.' );
		} else if ( hour >= 15 && hour < 19 ) {
			out.push( 'School is out, and she still has the evening free.' );
		} else {
			out.push( 'She’s working right now, two hours at a time.' );
		}

		return out;
	}

	function say( weather ) {
		var lines = bank();
		var pick = lines[ Math.floor( Math.random() * lines.length ) ];
		el.innerHTML = '<span class="arrival-when">' + opening( weather ) + '</span> '
			+ '<span class="arrival-ask">' + pick + '</span>';
		el.hidden = false;
	}

	function sky( code ) {
		var n = Number( code );
		if ( n === 0 ) { return 'clear'; }
		if ( n === 1 || n === 2 ) { return 'mostly sunny'; }
		if ( n === 3 ) { return 'cloudy'; }
		if ( n === 45 || n === 48 ) { return 'foggy'; }
		if ( n >= 51 && n <= 57 ) { return 'drizzling'; }
		if ( n >= 61 && n <= 67 ) { return 'raining'; }
		if ( n >= 71 && n <= 77 ) { return 'snowing'; }
		if ( n >= 80 && n <= 82 ) { return 'showery'; }
		if ( n >= 95 ) { return 'stormy'; }
		return '';
	}

	function feels( temp ) {
		if ( temp <= 10 ) { return 'chilly'; }
		if ( temp <= 15 ) { return 'cool'; }
		if ( temp >= 32 ) { return 'hot'; }
		if ( temp >= 26 ) { return 'warm'; }
		return '';
	}

	say( null );

	if ( ! place || ! window.fetch ) {
		return;
	}

	fetch( 'https://api.open-meteo.com/v1/forecast?latitude=' + place.lat + '&longitude=' + place.lon
		+ '&current=temperature_2m,precipitation,weather_code&timezone=auto', { mode: 'cors' } )
		.then( function ( r ) { return r.ok ? r.json() : null; } )
		.then( function ( d ) {
			if ( ! d || ! d.current ) { return; }
			var temp = Math.round( d.current.temperature_2m );
			if ( isNaN( temp ) ) { return; }
			say( { temp: temp, rain: Number( d.current.precipitation ) > 0, sky: sky( d.current.weather_code ) } );
		} )
		.catch( function () {} );
}() );

( function () {
	var box = document.querySelector( 'textarea[data-holds]' );

	if ( ! box ) {
		return;
	}

	var where = box.getAttribute( 'data-holds' );
	var held;

	try {
		held = window.localStorage.getItem( where );
	} catch ( e ) {
		return;
	}

	if ( held && '' === box.value.trim() ) {
		box.value = held;
	}

	box.addEventListener( 'input', function () {
		try {
			window.localStorage.setItem( where, box.value );
		} catch ( e ) {}
	} );

	if ( box.form ) {
		box.form.addEventListener( 'submit', function () {
			try {
				window.localStorage.removeItem( where );
			} catch ( e ) {}
		} );
	}
} )();
