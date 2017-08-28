angular.module('Login', [])  
.service('LoginService', LoginService);

function LoginService($http) {
    this.setCookieLogin = function(id, name, acessToken) {
      return requisicao("php/redirectLogin.php", {function: 'setCookieLogin', php: 'redirectLogin', idFB: id, token: acessToken, nome: name}).then(function(success) {
          return requisicao("php/ninja.php", {function: 'verificaCadastro', php: 'ninja', id: id});
      });
    }

   this.getReqBackend = function(url, jsonData) {
      return requisicao(url, jsonData);
    };

    function requisicao(url, obj) {
      return $http.post(url, obj)
    }
}

LoginService.$inject = ['$http'];