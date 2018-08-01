;(function()
{
    'use strict';

    angular.module('app.colorante', ['app.service.colorante'])

        .controller('ColoranteController', ['$scope', '$filter', '$http', '$modal', '$interval', 'ColoranteService', function($scope, $filter, $http, $modal, $timeout, ColoranteService)  {
           
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
            $scope.colorantes = [];
            var modal;

            // Function for load table
            function MostarDatos() {
                ColoranteService.index().then(function(response) {
                    $scope.datas = response.data.records;
                    $scope.search();
                    $scope.select($scope.currentPage);
                });
            }

            function cargarModal(){
                ColoranteService.colorantes().then(function(response) {
                    $scope.colorantes = response.data.records;
                });
            }

            $scope.inventarioColoranteReporte = function(){ 
               
                window.location="../ws/excel/inventarioColorantes";
                createToast('success', '<strong>Éxito: </strong>'+'Reporte Creado Exitosamente');
                $timeout( function(){ closeAlert(0); }, 3000);
            
            }

            MostarDatos();
            cargarModal();

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
            $scope.saveData = function (data) {
                if ($scope.action == 'new') {
                    ColoranteService.store(data).then(
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
                    ColoranteService.update(data).then(
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
                    ColoranteService.destroy(data.id).then(
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
            $scope.modalCreateOpen = function() {
                $scope.registro = {};
                $scope.registro.bodega = 0;
                $scope.registro.despacho = 0;
                $scope.registro.total = $scope.registro.bodega + $scope.registro.despacho;
                $scope.action = 'new'; 

                modal = $modal.open({
                    templateUrl: 'views/inventario/modal_inventarioColorante.html',
                    scope: $scope,
                    size: 'lg', 
                    backdrop: 'static',
                    keyboard: false,
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalEditOpen = function(data) {
                $scope.action = 'update';
                var dataColorante = data.colorante;
                $scope.registro = data;
                $scope.registro.colorante = dataColorante.colorante;
                $scope.registro.codigo = dataColorante.codigo;
                $scope.fecha = data.fecha +" 00:00:00";
                modal = $modal.open({
                    templateUrl: 'views/inventario/modal_inventarioColorante.html',
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
                    templateUrl: 'views/inventario/modal_inventarioColorante.html',
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

                ColoranteService.show(data.id).then(function successCallback(response){
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
               
            $scope.modalClose = function() {
                modal.close();
                MostarDatos();
            }
        }])
}());