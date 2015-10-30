require.config({
    baseUrl: "/assets/js",
    paths: {
        jquery: "../bower_components/jquery/dist/jquery",
        requirejs: "../bower_components/requirejs/require",
    },
});

// Загружаем наше приложение (главный скрипт)
require( [ "dist-about" ] );