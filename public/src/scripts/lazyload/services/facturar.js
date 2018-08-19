var contactos_service = angular.module('app.service.facturar', ['app.constants']);

contactos_service.service('FacturarService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'facturar');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'ordenes', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'ordenes/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'ordenes/' + id);
    };

    this.clientes = function(params){
        return $http.get(WS_URL+'clientes');
    };

    this.estilos = function(params){
        return $http.get(WS_URL+'estilos');
    };
    
    this.calibres = function(params){
        return $http.get(WS_URL+'calibres');
    };

    this.metrajes = function(params){
        return $http.get(WS_URL+'metraje');
    };

    this.colores = function(params){
        return $http.get(WS_URL+'colores');
    };
   
    this.referencias = function(params){
        return $http.get(WS_URL+'referencias');
    };

    this.lugares = function(params){
        return $http.get(WS_URL+'lugares');
    };

    this.tipos = function(params){
        return $http.get(WS_URL+'tipoOrden');
    };

    this.estados = function(params){
        return $http.get(WS_URL+'estados');
    };

    this.muestra = function(params){
        return $http.post(WS_URL+'muestra', params);
    };

    this.show = function(id){
        return $http.get(WS_URL+'mostrar/muestra/'+id);
    };

    this.despachos = function(params){
        return $http.post(WS_URL+'despachos', params);
    };

    this.facturar = function(params){
        return $http.post(WS_URL+'facturar', params);
    };

    this.show_despachos = function(id){
        return $http.get(WS_URL+'mostrar/despacho/'+id);
    };
}]);