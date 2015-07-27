require(['config'], function (config) {

	require([
		'jquery',
		'fastclick'
	], function (
		$,
		FastClick
	) {

		FastClick.attach(document.body);

	});

});