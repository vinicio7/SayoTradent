var contactos_service = angular.module('app.service.devanado', ['app.constants']);

contactos_service.service('DevanadoService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'devanado');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'devanado', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'devanado/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'devanado/' + id);
    };

    this.ordenes = function(params){
        return $http.get(WS_URL+'filtro/enconado');
    };
   
}]);