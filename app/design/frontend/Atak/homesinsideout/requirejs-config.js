var config = {
	deps: [
		"js/homesinsideout"
	],
	/*
	map: {
		'*': {
			owlcarousel: 'assets/owl.carousel/owl.carousel.min'
		}
	},
	*/
	paths: {
		owlcarousel: 'assets/owl.carousel/owl.carousel.min'
	},
	shim: {
		'owlcarousel': {
			'deps':  ['jquery']
		}
	}
};