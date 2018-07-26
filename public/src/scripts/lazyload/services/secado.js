var contactos_service = angular.module('app.service.secado', ['app.constants']);

contactos_service.service('SecadoService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'secado');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'secado', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'secado/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'secado/' + id);
    };

    this.ordenes = function(params){
        return $http.get(WS_URL+'filtro/teñido');
    };
   
}]);