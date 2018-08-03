var contactos_service = angular.module('app.service.calibres', ['app.constants']);

contactos_service.service('CalibresService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'hilos');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'hilos', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'hilos/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'hilos/' + id);
    };
   
}]);