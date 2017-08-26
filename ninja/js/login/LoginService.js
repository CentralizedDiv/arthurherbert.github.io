angular.module('Login', [])  
.service('LoginService', LoginService);

function LoginService($http) {
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

LoginService.$inject = ['$http'];