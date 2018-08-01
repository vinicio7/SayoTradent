var contactos_service = angular.module('app.service.estilo', ['app.constants']);

contactos_service.service('EstiloService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'estilo');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'estilo', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'estilo/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'estilo/' + id);
    };
   
}]);