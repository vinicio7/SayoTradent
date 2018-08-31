var contactos_service = angular.module('app.service.tenido', ['app.constants']);

contactos_service.service('TenidoService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'tenido');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'tenido', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'tenido/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'tenido/' + id);
    };

    this.ordenes = function(params){
        return $http.post(WS_URL+'ordenes/tenido');
    };
    
    this.consultarTenidas = function(params){
        return $http.post(WS_URL+'consultar/tenidas', params);
    };
   
}]);