require.config({
	"baseUrl": "/libs",
		"paths": {
			// "text": "../js/vendor/text",
			// "hbs": "require-handlebars-plugin/hbs",
			// "common": "../js/_common",
			// "app": "../js/_app",
			// "admin": "../js/_admin",

			"main.app": "../js/main.app",
			"main.admin": "../js/main.admin",

			"config": "../js/config",

			"text": "requirejs-text/text",

			"chart": "chartjs/Chart",

			// "templates/helpers": "../js/_common/templates/helpers",

			// "async":"requirejs-plugins/src/async",
			// "json":"requirejs-plugins/src/json",
			"jquery": "jquery/dist/jquery",
			// "underscore": "underscore/underscore",
			// "underscore.string": "underscore.string/dist/underscore.string",
			// "backbone": "backbone/backbone",
			// "backbone.mutators": "backbone.mutators/backbone.mutators",
			// "backbone.marionette": "marionette/lib/backbone.marionette",
			// "backbone.marionette.syphon": "marionette.backbone.syphon/lib/backbone.syphon",
			// "handlebars": "handlebars/handlebars.min",
			// "backbone.marionette.handlebars": "backbone.marionette.handlebars/backbone.marionette.handlebars",
			// "jqueryui": "jquery-ui/ui/jquery-ui",
			"fastclick": "fastclick/lib/fastclick",
			// "eventie": "eventie",
			// "eventEmitter": "eventEmitter",
			// "imagesloaded": "imagesloaded/imagesloaded.pkgd",
			// "bootstrap": "bootstrap-sass-official/assets/javascripts/bootstrap",
			// "messenger": "messenger/build/js/messenger"
		},
		"shim": {
			// "messenger": {
				// "deps": [
				//   "jquery",
				//   "backbone"
				// ],
				// "exports": "Messenger"
			// },
			// "bootstrap": ["jquery"],
			// "jquery-ui": ["jquery"],
			// "underscore": {
				// "exports": "_"
			// },
			// "handlebars": {
				// "exports": "Handlebars"
			// }
		},
		"deps": [

		],
		"hbs": {
			"templateExtension": "handlebars.html"
		},
		"waitSeconds": 20
	}
);