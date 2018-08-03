var contactos_service = angular.module('app.service.control', ['app.constants']);

contactos_service.service('ControlService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'control_calidada');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'control_calidada', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'control_calidada/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'control_calidada/' + id);
    };

    this.ordenes = function(params){
        return $http.post(WS_URL+'ordenes/calidad');
    };
   
}]);