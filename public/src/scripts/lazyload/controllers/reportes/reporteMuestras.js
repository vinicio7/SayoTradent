;(function()
{
    'use strict';

    angular.module('app.reportesMuestras', ['app.service.reportes'])

        .controller('ReportesMuestrasController', ['$scope', '$filter', '$http', '$modal', '$interval', 'ReportesService', function($scope, $filter, $http, $modal, $timeout, ReportesService)  {
           
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

            $scope.cambioDespacho = function(registro) {
                // ReportesService.filtrarMuestras(registro).then(function(response) {
                //     $scope.datas = response.data.records;
                //     $scope.search();
                //     $scope.select($scope.currentPage);
                // });
            };

            // Function for load table
            function MostrarDatos() {
                ReportesService.muestras().then(function(response) {
                    console.log(response.data.records);
                    $scope.datas = response.data.records;
                    $scope.search();
                    $scope.select($scope.currentPage);
                    cargarClientes();
                    cargarOrdenes();
                });
                console.log($scope.currentPageStores);
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

            $scope.muestrasReporte = function(){ 
               
                window.location="../ws/excel/muestras";
                createToast('success', '<strong>Éxito: </strong>'+'Reporte Creado Exitosamente');
                $timeout( function(){ closeAlert(0); }, 3000);
            
            }

            function closeAlert (index) {
                $scope.toasts.splice(index, 1);
            }

            // Functions of table
            $scope.select = function(page) {
                // console.log(page);
                var start = (page - 1)*$scope.numPerPage,
                    end = start + $scope.numPerPage;
                console.log($scope.currentPageStores);
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
                // console.log($scope.datas);
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

            MostrarDatos();
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