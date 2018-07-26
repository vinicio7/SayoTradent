var contactos_service = angular.module('app.service.proveedores', ['app.constants']);

contactos_service.service('ProveedoresService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'proveedores');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'proveedores', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'proveedores/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'proveedores/' + id);
    };

   
}]);