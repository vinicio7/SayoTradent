;(function () {
    'use strict';
    angular.module('app.constants', [])

        .constant('WS_URL', 'http://'+window.location.hostname+'/SayoTradent/public/ws/')
        .constant('API_URL', 'http://'+window.location.hostname+'/SayoTradent/public/api/')
        .constant('APP_URL', 'http://'+window.location.hostname+'/SayoTradent/public/');


}());
