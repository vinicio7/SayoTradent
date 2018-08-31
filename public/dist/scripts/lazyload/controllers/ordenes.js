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
            $scope.colores_orden = [];
            $scope.colores_mostrar = [];
            $scope.cantidad = 0;
            $scope.total_conos = 0;
            $scope.activar_editar = 0;
            var modal;
            $scope.contador = 0;
            $scope.total = 0;
            // Function for load table
            function MostarDatos() {
                OrdenesService.index().then(function(response) {
                    $scope.datas = response.data.records;
                    $scope.search();
                    $scope.select($scope.currentPage);
                });
            }


            function cargarModal(){
                OrdenesService.clientes().then(function(response){
                    $scope.clientes = response.data.records;
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
                    // console.log($scope.colores);
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

                OrdenesService.tipos().then(function(response){
                    $scope.tipos = response.data.records;
                });

                
               
            }

            $scope.borrarColor = function(){
                $scope.registro.color = "";
            }

            $scope.borrarMetraje = function(){
                $scope.registro.id_metraje = "";
            }

            $scope.borrarCalibre = function(){
                $scope.registro.id_calibre = "";
            }

            $scope.borrarTipo = function(){
                $scope.registro.tipo = "";
            }

            $scope.facturasReporte = function(){ 
               
                window.location="../ws/excel/facturas";
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

            $scope.eliminarColor = function (customer){
                var resta = parseFloat($scope.total) - parseFloat(customer.sub_total);
                var contador = parseInt( $scope.total_conos) - parseInt(customer.cantidad);
                $scope.total_conos = contador;
                $scope.total = resta;
                $scope.colores_mostrar.splice(customer.id, 1);
                $scope.colores_orden.splice(customer.id, 1);
            }
            
            $scope.saveEditarColor = function(customer){
                $scope.activar_editar = 0;
                for (var i = 0; i < $scope.colores_orden.length; i++) {
                    if ($scope.colores_orden[i].id == customer.id) {
                        var resta = parseFloat($scope.total) - parseFloat($scope.colores_orden[i].sub_total);
                        var contador = parseInt( $scope.total_conos) - parseInt($scope.colores_orden[i].cantidad);
                        $scope.total_conos = contador;
                        $scope.total = resta;
                        $scope.colores_mostrar.splice($scope.colores_orden[i].id, 1);
                        $scope.colores_orden.splice($scope.colores_orden[i].id, 1);
                        var suma = parseFloat($scope.total) + parseFloat($scope.colores_orden.sub_total);
                        $scope.total = suma.toFixed(2);
                        var total_conos = parseInt( $scope.total_conos) + parseInt($scope.colores_orden.cantidad);
                        $scope.total_conos = total_conos;
                        $scope.colores_orden[i] = customer;

                        var ca = customer.id_calibre.indexOf("-");
                        var id_calibre = customer.id_calibre.slice(ca+1, customer.id_calibre.length);

                        var ca = customer.id_metraje.indexOf("-");
                        var id_metraje = customer.id_metraje.slice(ca+1, customer.id_metraje.length);

                        var ca = customer.tipo.indexOf("-");
                        var tipo = customer.tipo.slice(ca+1, customer.tipo.length);
                        console.log($Scope.colores_mostrar[i]);
                        $scope.colores_mostrar[i].calibre.nombre = id_calibre;
                        $scope.colores_mostrar[i].metraje.nombre = id_metraje;
                        $scope.colores_mostrar[i].tipo.nombre = tipo;
                        $scope.colores_mostrar[i].po = customer.po;
                        $scope.colores_mostrar[i].estilo = customer.estilo;
                        $scope.colores_mostrar[i].descripcion = customer.descripcion;
                        $scope.colores_mostrar[i].cantidad = customer.cantidad;
                        $scope.colores_mostrar[i].precio = customer.precio;
                        $scope.colores_mostrar[i].referencia = customer.referencia;
                        $scope.colores_mostrar[i].lugar = customer.lugar;
                        $scope.colores_mostrar[i].id_estado = customer.id_estado;
                        $scope.colores_mostrar[i].sub_total = customer.sub_total;
                        console.log($scope.colores_mostrar);

                    }
                }
            }

            $scope.editarColor = function(customer){
                $scope.activar_editar = 1;
                console.log(customer);
                for (var i = 0; i < $scope.colores_orden.length; i++) {
                    if ($scope.colores_orden[i].id == customer.id) {
                        console.log($scope.colores_orden[i]);
                        $scope.registro.po = $scope.colores_orden[i].po;
                        $scope.registro.estilo = $scope.colores_orden[i].estilo;
                        $scope.registro.tipo = $scope.colores_orden[i].tipo +' -'+customer.tipo.nombre;
                        $scope.registro.descripcion = $scope.colores_orden[i].descripcion;
                        $scope.registro.id_calibre = $scope.colores_orden[i].id_calibre +' -'+customer.calibre.nombre;
                        $scope.registro.id_metraje = $scope.colores_orden[i].id_metraje +' -'+customer.metraje.nombre;
                        $scope.registro.color = $scope.colores_orden[i].color;
                        $scope.registro.cantidad = $scope.colores_orden[i].cantidad;
                        $scope.registro.precio = $scope.colores_orden[i].precio;
                        $scope.registro.sub_total = $scope.colores_orden[i].sub_total;
                        $scope.registro.referencia = $scope.colores_orden[i].referencia;
                        $scope.registro.lugar = $scope.colores_orden[i].lugar;
                        $scope.registro.id_estado = $scope.colores_orden[i].id_estado;
                    }
                }
            }

            $scope.limpiarColor = function(customer){
                $scope.registro.po = '';
                $scope.registro.estilo = '';
                $scope.registro.tipo = '';
                $scope.registro.descripcion = '';
                $scope.registro.id_calibre = '';
                $scope.registro.id_metraje = '';
                $scope.registro.color = '';
                $scope.registro.cantidad = '';
                $scope.registro.precio = '';
                $scope.registro.sub_total = '';
                $scope.registro.referencia = '';
                $scope.registro.lugar = '';
                $scope.registro.id_estado = '';
            }

            $scope.saveColor = function (customer){
                var color_solo = {};

                var ca = customer.id_calibre.indexOf(" -");
                var id_calibre = customer.id_calibre.slice(0, ca);
                color_solo.id_calibre = id_calibre;

                var ca = customer.id_metraje.indexOf(" -");
                var id_metraje = customer.id_metraje.slice(0, ca);
                color_solo.id_metraje= id_metraje;

                var ca = customer.tipo.indexOf(" -");
                var tipo = customer.tipo.slice(0, ca);
                color_solo.tipo = tipo;

                // var ca = customer.id_color.indexOf(" -");
                // var id_color = customer.id_color.slice(0, ca);
                // color_solo.id_color = id_color;
                color_solo.color = customer.color;
                color_solo.id = $scope.contador;
                color_solo.po = customer.po;
                color_solo.estilo = customer.estilo;
                color_solo.descripcion = customer.descripcion;
                color_solo.cantidad = customer.cantidad;
                color_solo.precio = customer.precio;
                color_solo.referencia = customer.referencia;
                color_solo.lugar = customer.lugar;
                color_solo.sub_total = customer.sub_total;
                color_solo.id_estado = customer.id_estado;
                color_solo.id = $scope.contador;

                var color_mostrar = new Object();
                var calibre = new Object();
                var metraje = new Object();
                var tipo = new Object();
                var color = new Object();
                // console.log(color_solo);

                color_mostrar.calibre = calibre;
                color_mostrar.metraje = metraje
                color_mostrar.tipo = tipo;
                color_mostrar.color = customer.color;

                var ca = customer.id_calibre.indexOf("-");
                var id_calibre = customer.id_calibre.slice(ca+1, customer.id_calibre.length);
                color_mostrar.calibre.nombre = id_calibre;

                var ca = customer.id_metraje.indexOf("-");
                var id_metraje = customer.id_metraje.slice(ca+1, customer.id_metraje.length);
                color_mostrar.metraje.nombre = id_metraje;

                var ca = customer.tipo.indexOf("-");
                var tipo = customer.tipo.slice(ca+1, customer.tipo.length);
                color_mostrar.tipo.nombre = tipo;

                // var ca = customer.id_color.indexOf("-");
                // var id_color = customer.id_color.slice(ca+1, customer.id_color.length);
                // color_mostrar.color.nombre = id_color;

                color_mostrar.id = $scope.contador;
                color_mostrar.po = customer.po;
                color_mostrar.estilo = customer.estilo;
                color_mostrar.descripcion = customer.descripcion;
                color_mostrar.cantidad = customer.cantidad;
                color_mostrar.precio = customer.precio;
                color_mostrar.referencia = customer.referencia;
                color_mostrar.lugar = customer.lugar;
                color_mostrar.id_estado = customer.id_estado;
                color_mostrar.sub_total = customer.sub_total;

                $scope.colores_mostrar.push(color_mostrar);
                // console.log(color_solo);
                $scope.colores_orden.push(color_solo);
                $scope.contador = parseInt($scope.contador) + 1;
                var suma = parseFloat($scope.total) + parseFloat(customer.sub_total);
                $scope.total = suma.toFixed(2);
                var total_conos = parseInt( $scope.total_conos) + parseInt(customer.cantidad);
                $scope.total_conos = total_conos;

            }
            $scope.calcular = function(){
                // console.log("entro a calcular");
                var suma = $scope.registro.sub_total = parseFloat($scope.registro.precio) * parseFloat($scope.registro.cantidad);
                // console.log(suma);
                $scope.registro.sub_total = suma.toFixed(2);
            }
            // Function for sending data
            $scope.saveData = function (customer) {
                if ($scope.action == 'new') {
                    var clone_customer = Object.assign({}, customer);
                    var index = customer.id_empresa.indexOf(" -");
                    var id_empresa = customer.id_empresa.slice(0, index);
                    clone_customer.id_empresa = id_empresa;

                    // var estilo = customer.id_estilo.indexOf(" -");
                    // var id_estilo = customer.id_estilo.slice(0, estilo);
                    // clone_customer.id_estilo = id_estilo;

                    var calibres = customer.id_calibre.indexOf(" -");
                    var id_calibre = customer.id_calibre.slice(0, calibres);
                    clone_customer.id_calibre = id_calibre;

                    var metraje = customer.id_metraje.indexOf(" -");
                    var id_metraje = customer.id_metraje.slice(0, metraje);
                    clone_customer.id_metraje = id_metraje;

                    // var color = customer.id_color.indexOf(" -");
                    // var id_color = customer.id_color.slice(0, color);
                    // clone_customer.id_color = id_color;

                    // var referencia = customer.id_referencias.indexOf(" -");
                    // var id_referencias = customer.id_referencias.slice(0, referencia);
                    // clone_customer.id_referencias = id_referencias;

                    // var lugar = customer.id_lugar.indexOf(" -");
                    // var id_lugar = customer.id_lugar.slice(0, lugar);
                    // clone_customer.id_lugar = id_lugar;

                    var tipoorden = customer.tipo.indexOf(" -");
                    var id_tipoorden = customer.tipo.slice(0, tipoorden);
                    clone_customer.tipo = id_tipoorden;
                    console.log(clone_customer);
                    clone_customer.colores_orden = JSON.stringify($scope.colores_orden);
                    clone_customer.total = $scope.total;
                    OrdenesService.store(clone_customer).then(
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
                else if ($scope.action == 'facturar') {
                    customer.orden_id = $scope.registro.id;
                    customer.cliente_id = $scope.registro.id_empresa;
                    customer.emision_dolares = $scope.registro.precio;
                    customer.tipo_cambio = 7.43;
                    customer.factura_quetzales = customer.emision_dolares * customer.tipo_cambio;
                    customer.fecha = new Date();
                    // console.log(customer);
                    OrdenesService.facturar(customer).then(
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

            $scope.addMuestra = function (data) {
                console.log("llego");
                console.log(data);
            }

            // Functions for modals
            $scope.modalCreateOpen = function() {
                $scope.colores_orden = [];
                $scope.registro = {};
                $scope.action = 'new'; 

                modal = $modal.open({
                    templateUrl: 'views/registro/modal_registro.html',
                    scope: $scope,
                    size: 'lg', 
                    backdrop: 'static',
                    keyboard: false,
                    resolve: function() {},
                    windowClass: 'default'
                });
            };

            $scope.modalInfo = function(customer) {
                OrdenesService.consultarOrden(customer.id_orden).then(
                    function successCallback(response) {
                        if (response.data.result) {
                            // console.log(response.data.records.hora);
                            $scope.action = "update";
                            response.data.records.hora = new Date(response.data.records.fecha_hora+' '+response.data.records.hora);
                            response.data.records.fecha_hora = new Date(response.data.records.fecha_hora);
                            response.data.records.id_empresa = response.data.records.id_empresa + ' - ' +response.data.records.cliente.nombre;
                            $scope.registro = response.data.records;
                            $scope.colores_orden = response.data.records.colores_orden;
                            $scope.total = response.data.records.precio_total;
                            $scope.total_conos = response.data.records.amount;
                            modal = $modal.open({
                                templateUrl: 'views/registro/modal_registro.html',
                                scope: $scope,
                                size: 'lg', 
                                backdrop: 'static',
                                keyboard: false,
                                resolve: function() {},
                                windowClass: 'default'
                            });
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

            $scope.modalFacturar = function(data) {
                $scope.action = 'facturar';
                $scope.registro = data;
                modal = $modal.open({
                    templateUrl: 'views/registro/modal_facturar.html',
                    scope: $scope,
                    size: 'lg',
                    resolve: function() {},
                    windowClass: 'default'
                });
            
            };

            $scope.modalMuestra = function(data) {
                $scope.id_muestra = data.id_orden;
                $scope.action = 'muestra';
                $scope.datos = {};
                console.log(data.id_orden);
                OrdenesService.show(data.id_orden).then(function successCallback(response){
                    $scope.prueba = response.data.records;
                    console.log(response.data.records);
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