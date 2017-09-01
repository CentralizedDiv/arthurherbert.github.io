angular.module('Ninja', [])  
.service('NinjaService', NinjaService);

function NinjaService($http) {
	 this.getReqBackend = function(url, jsonData) {
      return requisicao(url, jsonData);
    };

    function requisicao(url, obj) {
      return $http.post(url, obj)
    }
}

NinjaService.$inject = ['$http'];