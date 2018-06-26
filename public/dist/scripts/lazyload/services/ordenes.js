var contactos_service = angular.module('app.service.ordenes', ['app.constants']);

contactos_service.service('OrdenesService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'ordenes');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'ordenes', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'ordenes/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'ordenes/' + id);
    };

    
   
}]);