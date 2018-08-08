;(function()
{
    'use strict';

    angular.module('app.control', ['app.service.control'])

        .controller('ControlController', ['$scope', '$filter', '$http', '$modal', '$interval', 'ControlService','WS_URL', function($scope, $filter, $http, $modal, $timeout, ControlService,WS_URL)  {
           
            // General variables
            $scope.datas = [];
            $scope.datas1 = [];
            $scope.currentPageStores = [];
            $scope.searchKeywords = '';
            $scope.filteredData = [];
            $scope.row = '';
            $scope.numPerPageOpts = [5, 10, 25, 50, 100];
            $scope.numPerPage = $scope.numPerPageOpts[1];
            $scope.currentPage = 1;
            $scope.positionModel = 'topRight';
            $scope.toasts = [];

            var modal;

            // Function for load table
            function MostarDatos() {
                ControlService.ordenes().then(function(response) {
                    $scope.datas = response.data.records;
                    $scope.search();
                    $scope.select($scope.currentPage);      
                });
                
            } 

            $scope.tablaql = function(item){
                console.log(item);
                var revisar, acepta, rechaza ;
                if(item.cantidad_cajas >1 && item.cantidad_cajas <16 ){
                    revisar = 2;
                    acepta = 0;
                    rechaza = 1;
                    console.log(revisar,acepta,rechaza);
                }else if(item.cantidad_cajas >15 && item.cantidad_cajas <26 ){
                    revisar = 3;
                    acepta = 0;
                    rechaza = 1;
                    console.log(revisar,acepta,rechaza);
                }else if(item.cantidad_cajas >25 && item.cantidad_cajas <51 ){
                    revisar = 5;
                    acepta = 0;
                    rechaza = 1;
                    console.log(revisar,acepta,rechaza);
                }else if(item.cantidad_cajas >50 && item.cantidad_cajas <91 ){
                    revisar = 5;
                    acepta = 0;
                    rechaza = 1;
                    console.log(revisar,acepta,rechaza);
                }else if(item.cantidad_cajas >90 && item.cantidad_cajas <151 ){
                    revisar = 8;
                    acepta = 1;
                    rechaza = 2;
                    console.log(revisar,acepta,rechaza);
                }else if(item.cantidad_cajas >150 && item.cantidad_cajas <281 ){
                    revisar = 13;
                    acepta = 1;
                    rechaza = 2;
                    console.log(revisar,acepta,rechaza);
                }else if(item.cantidad_cajas >280 && item.cantidad_cajas <501 ){
                    revisar = 20;
                    acepta = 1;
                    rechaza = 2;
                    console.log(revisar,acepta,rechaza);
                }else if(item.cantidad_cajas >500 && item.cantidad_cajas <1201 ){
                    revisar = 32;
                    acepta = 2;
                    rechaza = 3;
                    console.log(revisar,acepta,rechaza);
                }else if(item.cantidad_cajas >1200 && item.cantidad_cajas <3201 ){
                    revisar = 50;
                    acepta = 3;
                    rechaza = 4;
                    console.log(revisar,acepta,rechaza);
                }else if(item.cantidad_cajas >3200 && item.cantidad_cajas <10001 ){
                    revisar = 80;
                    acepta = 5;
                    rechaza = 6;
                    console.log(revisar,acepta,rechaza);
                }else if(item.cantidad_cajas >10000 && item.cantidad_cajas <35001 ){
                    revisar = 125;
                    acepta = 7;
                    rechaza = 8;
                    console.log(revisar,acepta,rechaza);
                }
                $scope.registro.cantidad_revisada =revisar;
                $scope.registro.aceptada =acepta;
                $scope.registro.rechazada =rechaza;
            }

            $scope.redirect = function(){ 
               
                window.location="../ws/excel/control";
                createToast('success', '<strong>Éxito: </strong>'+'Reporte Creado Exitosamente');
                $timeout( function(){ closeAlert(0); }, 3000);
            
            }

            // Functions of table
            $scope.select = function(page) {
                var start = (page - 1)*$scope.numPerPage,
                    end = start + $scope.numPerPage;

                $scope.currentPageStores = $scope.filteredData.slice(start, end);
                
            };

            $scope.onFilterChange = function() {
                $scope.select(1);
                $scope.currentPage = 1;
                $scope.row = '';
            };

            $scope.onNumPerPageChange = function() {
                $scope.select(1);
                $scope.currentPage = 1;
            };

            $scope.onOrderChange = function() {
                $scope.select(1);
                $scope.currentPage = 1;
            };

            $scope.search = function() {
                $scope.filteredData = $filter('filter')($scope.datas, $scope.searchKeywords);
                $scope.onFilterChange();
            };

            $scope.order = function(rowName) {
                if($scope.row == rowName)
                    return;
                $scope.row = rowName;
                $scope.filteredData = $filter('orderBy')($scope.datas, rowName);
                $scope.onOrderChange();
            };

            MostarDatos();

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

            // Function for sending data
            $scope.saveData = function (customer) {
                console.log(customer);
                if ($scope.action == 'new') {
                    ControlService.store(customer).then(
                        function successCallback(response) {
                            if (response.data.result) {
                                MostarDatos();
                                modal.close();
                                createToast('success', '<strong>Éxito: </strong>'+response.data.message);
                                $timeout( function(){ closeAlert(0); }, 3000);
                            } else {
                                createToast('danger', '<strong>Error: </strong>'+response.data.message);
                                $timeout( function(){ closeAlert(0); }, 3000);
                            }
                        },
                        function errorCallback(response) {
                            createToast('danger', '<strong>Error: </strong>'+response.data.message);
                            $timeout( function(){ closeAlert(0); }, 3000);
                        }
                    );
                }
                else if ($scope.action == 'update') {
                    console.log(customer);
                    ControlService.update(customer).then(
                        function successCallback(response) {
                            if (response.data.result) {
                                modal.close();
                                createToast('success', '<strong>Éxito: </strong>'+response.data.message);
                                $timeout( function(){ closeAlert(0); }, 3000);
                            } else {
                                createToast('danger', '<strong>Error: </strong>'+response.data.message);
                                $timeout( function(){ closeAlert(0); }, 3000);
                            }
                        },
                        function errorCallback(response) {
                            createToast('danger', '<strong>Error: </strong>'+response.data.message);
                            $timeout( function(){ closeAlert(0); }, 3000);
                        }
                    );
                }
                else if ($scope.action == 'delete') {
                    // console.log(customer);
                    ControlService.destroy(customer.id_orden).then(
                        function successCallback(response) {
                            if (response.data.result) {
                                MostarDatos();
                                modal.close();
                                createToast('success', '<strong>Éxito: </strong>'+response.data.message);
                                $timeout( function(){ closeAlert(0); }, 3000);
                            } else {
                                createToast('danger', '<strong>Error: </strong>'+response.data.message);
                                $timeout( function(){ closeAlert(0); }, 3000);
                            }
                        },
                        function errorCallback(response) {
                            createToast('danger', '<strong>Error: </strong>'+response.data.message);
                            $timeout( function(){ closeAlert(0); }, 3000);
                        }
                    );
                }
            };   
            // Functions for modals
            $scope.modalCreateOpen = function(data) {
                console.log("llego despues del click");
                $scope.registro = {};
                $scope.action = 'new'; 
                console.log(data.id);
                $scope.registro.id_orden = data.id;
                modal = $modal.open({
                    templateUrl: 'views/control_calidad/modal_control.html',
                    scope: $scope,
                    size: 'lg', 
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalStopOpen = function(data) {
                $scope.registro = {};
                $scope.action = 'delete'; 
                $scope.registro.id_orden = data.id;
                modal = $modal.open({
                    templateUrl: 'views/bodega/modal_control.html',
                    scope: $scope,
                    size: 'md', 
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalEditOpen = function(data) {
                $scope.action = 'update';
                $scope.registro = data;
                console.log(data);
                
                modal = $modal.open({
                    templateUrl: 'views/control_calidad/modal_control.html',
                    scope: $scope,
                    size: 'lg',
                    resolve: function() {},
                    windowClass: 'default'
                });
            
            };

            $scope.modalDeleteOpen = function(data) {
                $scope.action = 'delete';
                $scope.proveedor = data;
                modal = $modal.open({
                    templateUrl: 'views/bodega/modal_control.html',
                    scope: $scope,
                    size: 'md',
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalClose = function() {
                modal.close();
                MostarDatos();
            }
        }])
}());