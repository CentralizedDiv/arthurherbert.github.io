angular.module('Login', [])  
.controller('LoginController', LoginController);

function LoginController(widget, LoginService) {

    widget.FBLogin = function() {
      FB.login(function(response){
        if(response.authResponse) {
          FB.api('/me', function(response) {
            var acessToken = FB.getAuthResponse();
            verificarCadastroFacebook(response.id, response.name, acessToken.accessToken);
          });
        }
        else {
          console.log('DEU RUIM');
        }

      }, {scope: 'public_profile,email,user_friends'});
    };

    widget.login = function() {
      LoginService.login(this.usuario, this.password).then(function successCallback(response) {
            if(response.data.naocadastrado === true) alert('Usuario não cadastrado');
            else if(response.data.senhaincorreta) alert('Senha incorreta');
            else window.location.href = 'index.html';
        }, function errorCallback(response) {
          return alert("Erro:" + response);
        });
    };

    function verificarCadastroFacebook(id, name, accessToken) {      
        LoginService.verificarCadastroFacebook(id, name, accessToken).then(function successCallback(response) {
            if(response.data.cadastrado === false) cadastroFacebook(id, name, accessToken);
            else setCookieLogin(id, name, accessToken);
        }, function errorCallback(response) {
          return alert("Erro:" + response);
        }); 
    };
    function cadastroFacebook(id, name, acessToken) {
        LoginService.getMe().then(function successCallback(response) {
          window.sessionStorage.setItem('me', JSON.stringify(response.data.me));
          window.location.href = 'signup.html';
        }, function errorCallback(response) {
            return alert("Erro:" + response);
        });  
    };
    
    function setCookieLogin(id, name, accessToken) {
      LoginService.setCookieLogin(id, name, accessToken).then(function successCallback(response) {
        if(response.data.cadastrado || response.data.cadastroRealizado) window.location.href = 'index.html';
        if(response.data.erroCadastro) alert("Ocorreu um erro ao realizar o login com facebook.");
      }, function errorCallback(response) {
          return alert("Erro:" + response);
      });    
    };
    
    /* 
    widget.getAmigosBackend = function() {
    
      LoginService.getReqBackend("php/facebook.php", {function: 'getEmail', php: 'facebook'});
    }
    */


    // -------------------------------------- CHAMADA BACKEND ---------------------------------------------- //

     

};

LoginController.$inject = ['$scope', 'LoginService'];