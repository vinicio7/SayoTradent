var contactos_service = angular.module('app.service.hilo', ['app.constants']);

contactos_service.service('HiloService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'hilo');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'hilo', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'hilo/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'hilo/' + id);
    };
}]);