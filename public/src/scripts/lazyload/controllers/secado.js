;(function()
{
    'use strict';

    angular.module('app.secado', ['app.service.secado'])

        .controller('SecadoController', ['$scope', '$filter', '$http', '$modal', '$interval', 'SecadoService','WS_URL', function($scope, $filter, $http, $modal, $timeout, SecadoService,WS_URL)  {
           
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
                SecadoService.ordenes().then(function(response) {
                    $scope.datas = response.data.records;
                    console.log($scope.datas);
                    $scope.search();
                    $scope.select($scope.currentPage);      
                });
                
            } 

            $scope.redirect = function(){ 
               
                window.location="../ws/excel/proveedores";
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
                var fecha = new Date(customer.fecha);
                // console.log(fecha);
                console.log(customer);
                if ($scope.action == 'new') {
                    SecadoService.store(customer).then(
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
                    SecadoService.update(customer).then(
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
                    console.log(customer)
                    SecadoService.destroy(customer.id_orden).then(
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
                $scope.registro = {};
                $scope.action = 'new'; 
                $scope.registro.id_orden = data.id;
                modal = $modal.open({
                    templateUrl: 'views/bodega/modal_secado.html',
                    scope: $scope,
                    size: 'lg', 
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalEditOpen = function(data) {
                $http({
                    method: 'GET',
                    url:    WS_URL+'secado/'+data.secado.id
                })
                .then(function succesCallback (response) {
                    if( response.data.result ) {
                        data = response.data.records;
                        $scope.registro = response.data.records;
                    }
                },
                function errorCallback(response) {
                    createToast('danger', '<strong>Error: </strong>'+response.data.message);
                    $timeout( function(){ closeAlert(0); }, 3000);
                })
                $scope.action = 'update';
                $scope.registro = data;
                
                modal = $modal.open({
                    templateUrl: 'views/bodega/modal_secado.html',
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
                    templateUrl: 'views/bodega/modal_tenido.html',
                    scope: $scope,
                    size: 'md', 
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalDeleteOpen = function(data) {
                $scope.action = 'delete';
                $scope.proveedor = data;
                modal = $modal.open({
                    templateUrl: 'views/bodega/modal_secado.html',
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