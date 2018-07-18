var contactos_service = angular.module('app.service.enconado', ['app.constants']);

contactos_service.service('EnconadoService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'enconado');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'enconado', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'enconado/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'enconado/' + id);
    };

    this.ordenes = function(params){
        return $http.get(WS_URL+'filtro/secado');
    };
   
}]);