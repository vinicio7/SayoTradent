;(function()
{
    'use strict';

    angular.module('app.reportesEstadoCuentaOrden', ['app.service.reportes'])

        .controller('ReportesEstadoCuentaOrdenController', ['$scope', '$filter', '$http', '$modal', '$interval', 'ReportesService', function($scope, $filter, $http, $modal, $timeout, ReportesService)  {
           
            // General variables
            $scope.datas = [];
            $scope.fechaInicio = new Date();
            $scope.fechaInicio.setDate($scope.fechaInicio.getDate() - 30);
            $scope.fechaFin = new Date();
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

            $scope.cambioEstadoCuenta = function(registro) {
                ReportesService.filtrarEstadoCuenta(registro).then(function(response) {
                    $scope.datas = response.data.records;
                    $scope.search();
                    $scope.select($scope.currentPage);
                });
            };
            // Function for load table
            $scope.MostrarDatos = function() {
                var dateinicio = $filter('date')($scope.fechaInicio,'yyyy-MM-dd');
                var datefin = $filter('date')($scope.fechaFin,'yyyy-MM-dd');

                ReportesService.estadoCuentaOrden(dateinicio, datefin).then(function(response) {
                    $scope.datas = response.data.records;
                    $scope.search();
                    $scope.select($scope.currentPage);

                    cargarClientes();
                    cargarOrdenes();
                });
            }

            function cargarClientes(){
                ReportesService.clientes().then(function(response){
                    $scope.clientes = response.data.records;
                });
            }

            function cargarOrdenes(){
                ReportesService.ordenes().then(function(response){
                    $scope.ordenes = response.data.records;
                });
            }

            function cargarModal(){
               
            }

            $scope.estadoCuentaOrdenReporte = function(){ 
                var dateinicio = $filter('date')($scope.fechaInicio,'yyyy-MM-dd');
                var datefin = $filter('date')($scope.fechaFin,'yyyy-MM-dd');
               
                window.location="../ws/excel/estadoCuentaOrden/"+dateinicio+"/"+datefin;
                createToast('success', '<strong>Éxito: </strong>'+'Reporte Creado Exitosamente');
                $timeout( function(){ closeAlert(0); }, 3000);
            
            }

            function closeAlert (index) {
                $scope.toasts.splice(index, 1);
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

            $scope.MostrarDatos();
            cargarModal();

            // Function for toast
            function createToast (type, message) {
                $scope.toasts.push({
                    anim: 'bouncyflip',
                    type: type,
                    msg: message
                });
            }
        }])
}());