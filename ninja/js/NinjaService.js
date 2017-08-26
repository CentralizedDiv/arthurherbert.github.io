angular.module('Ninjas', [])  
.service('NinjaService', NinjaService);

function NinjaService($http) {
	 this.getReqBackend = function(url, jsonData) {
       /* var REQ = { 
         url:   url,
         type:  type,
         data:  {data: jsonData}
      };
      return requisicaoAjax(REQ);*/
      return requisicao(url, jsonData);
    };

    function requisicao(url, obj) {
      return $http.post(url, obj)
    }
}

NinjaService.$inject = ['$http'];