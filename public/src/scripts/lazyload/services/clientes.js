var contactos_service = angular.module('app.service.clientes', ['app.constants']);

contactos_service.service('ClientesService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'clientes');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'clientes', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'clientes/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'clientes/' + id);
    };

   
}]);