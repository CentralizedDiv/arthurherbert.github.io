angular.module('Login', [])  
.controller('LoginController', LoginController);

function LoginController(widget, LoginService) {

    widget.FBLogin = function() {
      FB.login(function(response){
        if(response.authResponse) {
          FB.api('/me', function(response) {
            var acessToken = FB.getAuthResponse();
            setCookieLogin(response.id, response.name, acessToken.accessToken);
          });
        }
        else {
          console.log('DEU RUIM');
        }

      }, {scope: 'public_profile,email,user_friends'});
    };
    
    function setCookieLogin(id, name, acessToken) {
      LoginService.setCookieLogin(id, name, acessToken).then(function successCallback(response) {
        if(response.data.cadastrado || response.data.cadastroRealizado) window.location.href = 'signup.html';
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