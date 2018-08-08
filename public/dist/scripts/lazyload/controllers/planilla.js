;(function()
{
    'use strict';

    angular.module('app.planilla', ['app.service.planilla'])

        .controller('PlanillaController', ['$scope', '$filter', '$http', '$modal', '$interval', 'PlanillaService','WS_URL', function($scope, $filter, $http, $modal, $timeout, PlanillaService,WS_URL)  {
           
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
            $scope.habilitar2 = false;
            $scope.habilitar = true;
            $scope.datos2 = [];
            var modal;

            $scope.consultar = function(datos){
                PlanillaService.consultar(datos).then(
                        function successCallback(response) {
                            $scope.planilla = datos;
                            // $scope.planilla = response.data.records;
                            $scope.habilitar2 = false;
                            console.log(response.data.records);
                            if (response.data.result) {
                                createToast('success', '<strong>Éxito: </strong>'+response.data.message);
                                $timeout( function(){ closeAlert(0); }, 3000);
                            } else {
                                createToast('danger', '<strong>Error: </strong>'+response.data.message);
                                $timeout( function(){ closeAlert(0); }, 3000);
                            }
                        },
                        function errorCallback(response) {
                            console.log(response.data.records);
                            $scope.planilla = response.data.records;
                            $scope.habilitar2 = true;
                            createToast('danger', '<strong>Error: </strong>'+response.data.message);
                            $timeout( function(){ closeAlert(0); }, 3000);
                        }
                    );
            }

            $scope.encender = function(){
                console.log("encendido");
                $scope.habilitar = false;
            }
            // calcular suledo ordinario
            $scope.diasTrabajados = function(item){
                var numero ;
                if(item.dias_trabajados){
                     numero = (item.sueldo_base/30)*item.dias_trabajados;
                }else{
                     numero = 0;
                }
                $scope.planilla.sueldo_ordinario = numero.toFixed(2);

                // bono legal
                var bono ;
                if(item.dias_trabajados){
                    bono = (250/30)*item.dias_trabajados;
                }else{
                    bono = 0;
                }
                $scope.planilla.bon_legal = bono.toFixed(2);

                // extras dia
                var ex_dia ;
                if (item.horas_ex_dia) {
                    ex_dia = ((item.sueldo_base/30)/8)*1.5*item.horas_ex_dia;
                }else{
                    ex_dia = 0;
                };
                $scope.planilla.sueldo_ex_dia = ex_dia.toFixed(2);

                // extras noche
                var ex_noche ;
                if (item.horas_ex_noche) {
                    ex_noche = ((item.sueldo_base/30)/8)*2*item.horas_ex_noche;
                }else{
                    ex_noche = 0;
                };
                $scope.planilla.sueldo_ex_noche = ex_noche.toFixed(2);

                
                // total horas extras
                $scope.planilla.total_ex = parseFloat($scope.planilla.sueldo_ex_noche) + parseFloat($scope.planilla.sueldo_ex_dia);
            }
            // fin de calcular sueldo ordinario


            $scope.incentivos = function(item){
                var pn = item.bon_inc_base/2/12*item.incentivo_pn;
                $scope.planilla.incentivo_pn1 = pn.toFixed(2);

                var as = item.bon_inc_base/2/12*item.incentivo_as;
                $scope.planilla.incentivo_as1 = as.toFixed(2);

                var total_bn = parseFloat($scope.planilla.incentivo_pn1) + parseFloat($scope.planilla.incentivo_as1);
                $scope.planilla.total_bn_inc = total_bn.toFixed(2);

                var total_ingresos = parseFloat($scope.planilla.sueldo_ordinario) + parseFloat($scope.planilla.total_ex) + parseFloat($scope.planilla.bon_legal) + parseFloat($scope.planilla.total_bn_inc);
                $scope.planilla.total_ingresos = total_ingresos.toFixed(2);

                var igss = (parseFloat($scope.planilla.sueldo_ordinario) + parseFloat($scope.planilla.total_ex)) * 0.0483;
                $scope.planilla.igss = igss.toFixed(2);

                var total_des = parseFloat($scope.planilla.igss) + parseFloat($scope.planilla.isr) +  parseFloat($scope.planilla.otros_descuentos);
                $scope.planilla.total_descuentos = total_des.toFixed(2);

                var liquido = parseFloat($scope.planilla.total_ingresos) - parseFloat($scope.planilla.total_descuentos);
                $scope.planilla.total = liquido.toFixed(2);
            }

            // Function for load table
            function MostarDatos() {
                PlanillaService.index().then(function(response) {
                    $scope.datas = response.data.records;
                    $scope.search();
                    $scope.select($scope.currentPage);
                });
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
                if ($scope.action == 'new') {
                    PlanillaService.store(customer).then(
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
                    PlanillaService.update(customer).then(
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
                else if ($scope.action == 'detail') {
                    PlanillaService.modificar(customer).then(
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
                    console.log(customer);
                    PlanillaService.destroy(customer.id).then(
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
                $scope.planilla = {};
                $scope.action = 'new';
                
                modal = $modal.open({
                    templateUrl: 'views/administracion/modal_planilla.html',
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
                $scope.planilla = data;
                modal = $modal.open({
                    templateUrl: 'views/administracion/modal_planilla.html',
                    scope: $scope,
                    size: 'lg',
                    resolve: function() {},
                    windowClass: 'default'
                });

            };


            $scope.modalDetail = function(data){
                console.log(data);
                $http({
                    method: 'GET',
                    url:    WS_URL+'planilla/'+data.id
                })
                .then(function succesCallback (response) {
                    if( response.data.result ) {
                        data = response.data.records;
                        $scope.planilla = response.data.records;
                    }
                },
                function errorCallback(response) {
                    createToast('danger', '<strong>Error: </strong>'+response.data.message);
                    $timeout( function(){ closeAlert(0); }, 3000);
                })
                $scope.action = 'detail';
                $scope.planilla = data;
                console.log($scope.planilla);
                modal = $modal.open({
                    templateUrl: 'views/administracion/modal_planilla.html',
                    scope: $scope,
                    size: 'lg',
                    backdrop: 'static',
                    keyboard: false, 
                    resolve: function() {},
                    windowClass: 'default'
                });
            }

            $scope.modalDeleteOpen = function(data) {
                console.log(data);
                $scope.action = 'delete';
                $scope.planilla = data;
                modal = $modal.open({
                    templateUrl: 'views/administracion/modal_planilla.html',
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