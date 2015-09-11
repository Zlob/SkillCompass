require.config({
    baseUrl: "/assets/js",
    paths: {
        bootstrap: "../bower_components/bootstrap/dist/js/bootstrap",
        backbone: "../bower_components/backbone/backbone",
        underscore: "../bower_components/underscore/underscore",
        "backbone.epoxy": "../bower_components/backbone.epoxy/backbone.epoxy",
        jquery: "../bower_components/jquery/dist/jquery",
        requirejs: "../bower_components/requirejs/require",
        text: "../bower_components/text/text",
        Chart: "../bower_components/Chart.js/Chart"
    },
    shim: {
        bootstrap: {
            deps: [
                "jquery"
            ]
        }
    },
    packages: [

    ]
});

// Загружаем наше приложение (главный скрипт)
require( [ "app" ] );