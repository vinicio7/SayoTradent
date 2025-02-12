var contactos_service = angular.module('app.service.usuarios', ['app.constants']);

contactos_service.service('UsuariosService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'usuarios');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'usuarios', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'usuarios/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'usuarios/' + id);
    };

   
}]);