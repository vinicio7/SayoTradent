var contactos_service = angular.module('app.service.planilla', ['app.constants']);

contactos_service.service('PlanillaService', ['$http', 'WS_URL', function($http, WS_URL)  {
    delete $http.defaults.headers.common['X-Requested-With'];

    this.index = function(params){
        return $http.get(WS_URL+'planilla');
    };

    this.store = function(params) {
        return $http.post(WS_URL+'planilla', params);
    };

    this.consultar = function(params) {
        return $http.post(WS_URL+'consultar', params);
    };

    this.update = function(params) {
        return $http.put(WS_URL+'planilla/' + params.id, params);
    };

    this.destroy = function(id) {
        return $http.delete(WS_URL+'planilla/' + id);
    };

    this.modificar = function(params) {
        return $http.put(WS_URL+'modificar/planilla/' + params.id, params);
    };

    this.filtrar = function(params) {
        console.log(params);
        return $http.post(WS_URL+'filtrar/planilla', params);
    };
   
}]);