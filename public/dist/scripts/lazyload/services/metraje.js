var contactos_service = angular.module('app.service.metraje', ['app.constants']);

contactos_service.service('MetrajeService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'metrajes');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'metrajes', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'metrajes/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'metrajes/' + id);
    };
   
}]);