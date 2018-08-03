var contactos_service = angular.module('app.service.maseo', ['app.constants']);

contactos_service.service('MaseoService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'maseo');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'maseo', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'maseo/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'maseo/' + id);
    };

    this.ordenes = function(params){
        return $http.post(WS_URL+'ordenes/maseo');
    };
   
}]);