var contactos_service = angular.module('app.service.cuentas', ['app.constants']);

contactos_service.service('CuentasService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'cuentas');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'cuentas', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'cuentas/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'cuentas/' + id);
    };

   
}]);