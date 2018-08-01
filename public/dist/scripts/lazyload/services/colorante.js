var contactos_service = angular.module('app.service.colorante', ['app.constants']);

contactos_service.service('ColoranteService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'colorantes');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'colorantes', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'colorantes/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'colorantes/' + id);
    };

    this.colorantes = function(params) {
        return $http.get(WS_URL+'colorantesInfo');
    };
}]);