angular.module('SignUp', [])  
.service('SignUpService', SignUpService);

function SignUpService($http) {
  this.cadastrar = function(cadastro) {
      return requisicao("php/ninja.php", {function: 'cadastrar', php: 'ninja', me: cadastro});
  };

  this.setCookieLogin = function(id, name, acessToken) {
      return requisicao("php/redirectLogin.php", {function: 'verificaLogin', php: 'redirectLogin', token: '', id: id, nome: name});
  };

  function requisicao(url, obj) {
    return $http.post(url, obj)
  }
}

SignUpService.$inject = ['$http'];