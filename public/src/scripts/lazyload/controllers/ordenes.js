;(function()
{
    'use strict';

    angular.module('app.ordenes', ['app.service.ordenes'])

        .controller('OrdenesController', ['$scope', '$filter', '$http', '$modal', '$interval', 'OrdenesService', function($scope, $filter, $http, $modal, $timeout, OrdenesService)  {
           
            // General variables
            $scope.datas = [];
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
                OrdenesService.index().then(function(response) {
                    $scope.datas = response.data.records;
                    $scope.search();
                    $scope.select($scope.currentPage);
                });
            }


            function cargarModal(){
                OrdenesService.empresas().then(function(response){
                    $scope.empresas = response.data.records;
                });
                
                OrdenesService.estilos().then(function(response){
                    $scope.estilos = response.data.records;
                });

                OrdenesService.calibres().then(function(response){
                    $scope.calibres = response.data.records;
                });

                OrdenesService.metrajes().then(function(response){
                    $scope.metrajes = response.data.records;
                });

                OrdenesService.colores().then(function(response){
                    $scope.colores = response.data.records;
                });

                OrdenesService.referencias().then(function(response){
                    $scope.referencias = response.data.records;
                });

                OrdenesService.lugares().then(function(response){
                    $scope.lugares = response.data.records;
                });

                OrdenesService.estados().then(function(response){
                    $scope.estados = response.data.records;
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
            cargarModal();

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
                // console.log(customer);
                if ($scope.action == 'new') {
                    OrdenesService.store(customer).then(
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
                    OrdenesService.update(customer).then(
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
                    OrdenesService.destroy(customer.id).then(
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
                else if ($scope.action == 'muestra') {
                    customer.id_orden = $scope.id_muestra;
                    // console.log(customer);
                    OrdenesService.muestra(customer).then(
                        function successCallback(response) {
                            if (response.data.result) {
                                // MostarDatos();
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
                else if ($scope.action == 'despacho') {
                    customer.id_orden = $scope.id_despacho;
                    // console.log(customer);
                    OrdenesService.despachos(customer).then(
                        function successCallback(response) {
                            if (response.data.result) {
                                // MostarDatos();
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

            $scope.addMuestra = function (data) {
                console.log("llego");
                console.log(data);
            }


            // Functions for modals
            $scope.modalCreateOpen = function() {
                $scope.registro = {};
                $scope.action = 'new'; 
                modal = $modal.open({
                    templateUrl: 'views/registro/modal_registro.html',
                    scope: $scope,
                    size: 'lg', 
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalEditOpen = function(data) {
                $scope.action = 'update';
                $scope.registro = data;
                modal = $modal.open({
                    templateUrl: 'views/registro/modal_registro.html',
                    scope: $scope,
                    size: 'lg',
                    resolve: function() {},
                    windowClass: 'default'
                });
            
            };

            $scope.modalDeleteOpen = function(data) {
                $scope.action = 'delete';
                $scope.registro = data;
                modal = $modal.open({
                    templateUrl: 'views/registro/modal_registro.html',
                    scope: $scope,
                    size: 'md',
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalMuestra = function(data) {
                $scope.id_muestra = data.id;
                $scope.action = 'muestra';
                $scope.datos = {};

                OrdenesService.show(data.id).then(function successCallback(response){
                    $scope.prueba = response.data.records;
                });
                
                modal = $modal.open({
                    templateUrl: 'views/registro/modal_muetra.html',
                    scope: $scope,
                    size: 'lg',
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalDespacho = function(data) {
                $scope.id_despacho = data.id;
                $scope.action = 'despacho';
                $scope.datos = {};

                OrdenesService.show_despachos(data.id).then(function successCallback(response){
                    $scope.prueba = response.data.records;
                });

                
                modal = $modal.open({
                    templateUrl: 'views/registro/modal_despacho.html',
                    scope: $scope,
                    size: 'lg',
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalEntregado = function(data) {
                $scope.action = 'despacho';
                $scope.datos = {};

                OrdenesService.show_despachos(data.id).then(function successCallback(response){
                    $scope.salida = response.data.records;
                    console.log($scope.salida);
                });

                
                modal = $modal.open({
                    templateUrl: 'views/registro/modal_entregado.html',
                    scope: $scope,
                    size: 'lg',
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