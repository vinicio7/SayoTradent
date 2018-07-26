var contactos_service = angular.module('app.service.movimientos', ['app.constants']);

contactos_service.service('MovimientosService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'movimientos');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'movimientos', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'movimientos/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'movimientos/' + id);
    };

   
}]);