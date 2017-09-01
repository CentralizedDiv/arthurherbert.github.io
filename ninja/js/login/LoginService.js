angular.module('Login', [])  
.service('LoginService', LoginService);

function LoginService($http) {

    this.login = function(usuario, senha) {
        return requisicao("php/ninja.php", {function: 'login', php: 'ninja', user: usuario, password: senha});
    };

    this.setCookieLoginFacebook = function(id, acessToken) {
       return requisicao("php/redirectLogin.php", {function: 'verificaLoginFacebook', php: 'redirectLogin', idFB: id, token: acessToken, nome: ''});
    };

    this.setCookieLogin = function(id, name, acessToken) {
      return requisicao("php/redirectLogin.php", {function: 'verificaLogin', php: 'redirectLogin', idFB: id, token: acessToken, nome: name}).then(function(success) {
          return requisicao("php/ninja.php", {function: 'verificaCadastroFacebook', php: 'ninja', id: id});
      });
    };

    this.verificarCadastroFacebook = function(id, name, acessToken) {
      return this.setCookieLoginFacebook(id, acessToken).then(function(success) {
        return requisicao("php/ninja.php", {function: 'verificaCadastroFacebook', php: 'ninja', id: id});
      });
    };

    this.getReqBackend = function(url, jsonData) {
      return requisicao(url, jsonData);
    };

    this.getMe = function() {
      return requisicao("php/facebook.php", {function: 'getMe', php: 'facebook'});
    }

    function requisicao(url, obj) {
      return $http.post(url, obj)
    }
}

LoginService.$inject = ['$http'];