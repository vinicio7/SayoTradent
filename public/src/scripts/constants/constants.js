;(function () {
    'use strict';
    angular.module('app.constants', [])
         // .constant('WS_URL', 'http://localhost:8888/SayoTradent/public/ws/')
         // .constant('API_URL', 'http://localhost:8888/SayoTradent/public/api/')
         // .constant('APP_URL', 'http://localhost:8888/SayoTradent/public/');

        // .constant('WS_URL', 'http://localhost/SayoTradent/public/ws/')
        // .constant('API_URL', 'http://localhost/SayoTradent/public/api/')
        // .constant('APP_URL', 'http://localhost/SayoTradent/public/');

        .constant('WS_URL', 'http://'+window.location.hostname+'/sayotradent-web/public/ws/')
        .constant('API_URL', 'http://'+window.location.hostname+'/sayotradent-web/public/api/')
        .constant('APP_URL', 'http://'+window.location.hostname+'/sayotradent-web/public/');

}());
