var contactos_service = angular.module('app.service.color', ['app.constants']);

contactos_service.service('ColorService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'color');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'color', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'color/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'color/' + id);
    };
   
}]);