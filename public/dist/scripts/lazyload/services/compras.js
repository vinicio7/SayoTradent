var contactos_service = angular.module('app.service.compras', ['app.constants']);

contactos_service.service('ComprasService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'compras');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'compras', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'compras/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'compras/' + id);
    };

    this.proveedores = function(params){
        return $http.get(WS_URL+'proveedores');
    };

   
}]);