;(function()
{
    'use strict';
    angular.module('login', ["LocalStorageModule",
                            "ngRoute",
                            "ngAnimate",
                            "ngSanitize",
                            "ngAria",
                            "ngMaterial",
                            "oc.lazyLoad",
                            "ui.bootstrap",
                            "angular-loading-bar",
                            "FBAngular",
                            "app.ctrls",
                            "app.directives",
                            "app.ui.ctrls",
                            "app.ui.directives",
                            "app.form.ctrls",
                            "app.table.ctrls",
                            "app.email.ctrls",
                            "app.constants"])

        .controller('LoginController', ['$scope', '$http', '$timeout', "$window", "localStorageService", "WS_URL", function($scope, $http, $timeout, $window, localStorageService, WS_URL)  {

            $scope.positionModel = 'topRight';
            $scope.toasts = [];

            if (localStorageService.get('usuario')) {
                $window.location.href = './#/dashboard';
            }

            // Function for toast
            function createToast (type, message) {
                $scope.toasts.push({
                    anim: 'bouncyflip',
                    type: type,
                    msg: message
                });
            }

            function closeAlert (index) {
                $scope.toasts.splice(index, 1);
            }

            $scope.iniciarSesion = function (info) {
                // $window.location.href = './#/dashboard';
                $http({
                    method: 'POST',
                    url:    WS_URL+'login',
                    data:   info
                })
                .then(function succesCallback (response) {
                    if( response.data.result ) {
                        localStorageService.set('usuario',response.data.records);
                        console.log(localStorageService);
                        createToast('success', '<strong>Éxito: </strong>'+response.data.message);
                        $window.location.href = './#/dashboard';//

                    } else {
                        createToast('danger', '<strong>Error: </strong>'+response.data.message);
                        $timeout( function(){ closeAlert(0); }, 3000);
                    }
                },
                function errorCallback(response) {
                    createToast('danger', '<strong>Error: </strong>'+response.data.message);
                    $timeout( function(){ closeAlert(0); }, 3000);
                })
            };


            // $scope.resetPassword = function (info) {
            //     $http({
            //         method: 'POST',
            //         url:    WS_URL+'resetpassword',
            //         data:   info
            //     })
            //     .then(function succesCallback (response) {
            //         if( response.data.result ) {
            //             createToast('success', '<strong>Éxito: </strong>'+response.data.message);
            //             $timeout( function(){ closeAlert(0); }, 5000);
            //             setTimeout("location.href = './#/login'", 5000);

            //         } else {
            //             createToast('danger', '<strong>Error: </strong>'+response.data.message);
            //             $timeout( function(){ closeAlert(0); }, 3000);
            //         }
            //     },
            //     function errorCallback(response) {
            //         createToast('danger', '<strong>Error: </strong>'+response.data.message);
            //         $timeout( function(){ closeAlert(0); }, 3000);
            //     })
            // };
        }])
}());