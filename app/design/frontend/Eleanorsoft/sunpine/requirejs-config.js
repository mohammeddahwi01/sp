var config = {
    deps: [
        'jquery.bootstrap'
    ],
    paths: {
        'jquery.bootstrap': 'js/bootstrap.bundle.min',
        'jquery.selectric': 'js/jquery.selectric.min'
    },
    shim: {
        'jquery.bootstrap': {
            deps: ['jquery']
        },
        'jquery.selectric': {
            deps: ['jquery']
        }
    }
};
