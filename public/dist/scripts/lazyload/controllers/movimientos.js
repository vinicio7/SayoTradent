;(function()
{
    'use strict';

    angular.module('app.movimientos', ['app.service.movimientos'])

        .controller('MovimientosController', ['$scope', '$filter', '$http', '$modal', '$interval', 'MovimientosService', function($scope, $filter, $http, $modal, $timeout, MovimientosService)  {
           
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
            $scope.balance_q = 0;
            $scope.balance_d = 0;
            $scope.select_tipo = [];
            $scope.select_moneda = [];
            $scope.select_cuenta = [];
            var modal;

            $scope.cambioMovimiento = function(registro) {
                console.log(registro);
                MovimientosService.filtrar(registro).then(function(response) {
                    console.log(response.data.records);
                    $scope.datas = response.data.records;
                    $scope.search();
                    $scope.select($scope.currentPage);
                });
            };

            function cargarTipos(){
                var tipo = {};
                tipo.id = 1;
                tipo.descripcion = "Ingreso";
                $scope.select_tipo.push(tipo);
                var tipo2 = {};
                tipo2.id = 2;
                tipo2.descripcion = "Egreso";
                $scope.select_tipo.push(tipo2);
                console.log($scope.select_tipo);
            }

            function cargarMonedas(){
                var moneda = {};
                moneda.id = 1;
                moneda.descripcion = "Quetzales";
                $scope.select_moneda.push(moneda);
                var moneda2 = {};
                moneda2.id = 2;
                moneda2.descripcion = "Dolares";
                $scope.select_moneda.push(moneda2);
                console.log($scope.select_moneda);
            }

            function cargarCuentas(){
                MovimientosService.cargarCuentas().then(function(response) {
                    $scope.select_cuenta = response.data.records;
                    console.log($scope.select_cuenta);
                });
            }

            cargarCuentas();
            cargarMonedas();
            cargarTipos();
            // Function for load table
            function MostarDatos() {
                MovimientosService.index().then(function(response) {
                    $scope.datas = response.data.records;
                    $scope.balance_d = response.data.total_dolares;
                    $scope.balance_q = response.data.total_quetzales;
                    $scope.search();
                    $scope.select($scope.currentPage);
                });
            }

            $scope.redirect = function(){ 
               
                window.location="../ws/excel/movimientos?tipo="+$scope.movimiento.tipo+"&moneda="+$scope.movimiento.moneda+"&fecha_inicio="+$scope.movimiento.fecha_inicio+"&fecha_fin="+$scope.movimiento.fecha_fin+"&cuenta="+$scope.movimiento.cuenta;
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
             function cargarModal(){
             MovimientosService.cuentas().then(function(response){
                    $scope.cuentas = response.data.records;
                });
         }
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
                console.log(customer);
                if ($scope.action == 'new') {
                     var clone_customer = Object.assign({}, customer);
                    var cuenta = customer.cuenta_id.indexOf(" -");
                    var cuenta_id = customer.cuenta_id.slice(0, cuenta);
                    console.log(clone_customer);
                    console.log(cuenta);
                    console.log(cuenta_id);
                    clone_customer.cuenta_id = cuenta_id;
                    console.log(customer);
                    MovimientosService.store(customer).then(
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
                    MovimientosService.update(customer).then(
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
                else if ($scope.action == 'delete') {
                    MovimientosService.destroy(customer.id).then(
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
                
                $scope.movimiento = {};
                $scope.action = 'new'; 
                modal = $modal.open({
                    templateUrl: 'views/administracion/modal_movimientos.html',
                    scope: $scope,
                    size: 'lg', 
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalEditOpen = function(data) {
                $scope.action = 'update';
                $scope.movimiento = data;
                modal = $modal.open({
                    templateUrl: 'views/administracion/modal_movimientos.html',
                    scope: $scope,
                    size: 'lg',
                    resolve: function() {},
                    windowClass: 'default'
                });
            
            };

            $scope.modalDeleteOpen = function(data) {
                $scope.action = 'delete';
                $scope.movimiento = data;
                modal = $modal.open({
                    templateUrl: 'views/administracion/modal_movimientos.html',
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