;(function()
{
    'use strict';

    angular.module('app.maseo', ['app.service.maseo'])

        .controller('MaseoController', ['$scope', '$filter', '$http', '$modal', '$interval', 'MaseoService','WS_URL', function($scope, $filter, $http, $modal, $timeout, MaseoService,WS_URL)  {
           
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
            $scope.currentPageStores3 = [];
            $scope.numero = 0;
            $scope.tenidas = [];
            var modal;

            // Function for load table
            function MostarDatos() {
                MaseoService.ordenes().then(function(response) {
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

            $scope.addTenido = function(params){
                params.no = $scope.numero;
                $scope.currentPageStores3.push(params);
                console.log($scope.currentPageStores3);
                $scope.numero = $scope.numero + 1;
                createToast('success', '<strong>Éxito: </strong>'+'Añadido correctamente');
                                $timeout( function(){ closeAlert(0); }, 3000);
            }

            $scope.EliminarTenido = function(params){
                console.log(params);
                console.log($scope.currentPageStores3.lenght);
                $scope.currentPageStores3.splice(params.no, 1);
            }   

            MostarDatos();

            // Function for toast
            function createToast (type, message) {
                $scope.toasts.push({
                    anim: 'bouncyflip',
                    type: type,
                    msg: message
                });
            }

            $scope.calcularKilos = function(params){
                if ($scope.registro.tipo == 1) {
                    $scope.registro.quesos = $scope.registro.kilos;
                } else {
                    $scope.registro.quesos = $scope.registro.kilos / 1.4175;
                }
            }

            function closeAlert (index) {
                $scope.toasts.splice(index, 1);
            }

            // Function for sending data
            $scope.saveData = function (customer) {
                customer.colores_tenido = JSON.stringify($scope.currentPageStores3);
                if ($scope.action == 'new') {
                    console.log(customer);
                    TenidoService.store(customer).then(
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
                    TenidoService.update(customer).then(
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
                    console.log(customer[0].orden.id);
                    TenidoService.destroy(customer[0].orden.id).then(
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
            $scope.detailtenidas = function(data){
                $scope.tenidas = [];
                modal = $modal.open({
                    templateUrl: 'views/bodega/tenidas.html',
                    scope: $scope,
                    size: 'lg', 
                    resolve: function() {},
                    windowClass: 'default'
                });
            }
            // Functions for modals
            $scope.modalCreateOpen = function(data) {
                $scope.currentPageStores3 = [];
                $scope.registro = {};
                $scope.action = 'new';
                console.log(data); 
                // $scope.registro.id_orden = data.id_orden;
                // console.log($scope.registro.id_orden);
                modal = $modal.open({
                    templateUrl: 'views/bodega/modal_maseo.html',
                    scope: $scope,
                    size: 'lg', 
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalStopOpen = function(data) {
               console.log(data);
                $http({
                    method: 'GET',
                    url:    WS_URL+'buscar/'+data.id
                })
                .then(function succesCallback (response) {
                    if( response.data.result ) {
                        data = response.data.records;
                        $scope.registro = data;
                    }
                },
                function errorCallback(response) {
                    createToast('danger', '<strong>Error: </strong>'+response.data.message);
                    $timeout( function(){ closeAlert(0); }, 3000);
                })
                
                // $scope.registro = data;
                // console.log($scope.registro);
                $scope.action = 'delete'; 
                modal = $modal.open({
                    templateUrl: 'views/bodega/modal_tenido.html',
                    scope: $scope,
                    size: 'md', 
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalEditOpen = function(data) {
                console.log(data.tenido);
                var date = data.tenido.fecha;
                var newdate = date.split("-").reverse().join("/");
                data.tenido.fecha = newdate;
                console.log(data.tenido)
                console.log("llego");
                $http({
                    method: 'GET',
                    url:    WS_URL+'tenido/'+data.id
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
                    templateUrl: 'views/bodega/modal_tenido.html',
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
                    templateUrl: 'views/bodega/modal_tenido.html',
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