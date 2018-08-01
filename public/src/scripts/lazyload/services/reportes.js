var contactos_service = angular.module('app.service.reportes', ['app.constants']);

contactos_service.service('ReportesService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'reportes');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'reportes', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'reportes/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'reportes/' + id);
    };

    this.muestras = function(params){
        return $http.get(WS_URL+'muestras', params);
    };

    this.despachos = function(params){
        return $http.get(WS_URL+'despacho', params);
    };

    this.ordenesPorDia = function(params){
        return $http.get(WS_URL+'ordenesPorDia/' + params);
    };
    
    this.despachosDiarios = function(params){
        return $http.get(WS_URL+'despachosDiarios/' + params);
    };

    this.controlOrdenCafta = function(params, params1){
        return $http.get(WS_URL+'controlOrdenCafta/' + params + '/' + params1);
    };
}]);