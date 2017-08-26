function NinjaController(widget, NinjaService) {

    widget.fotoPerfil = getImagemPerfil();

    function getImagemPerfil() {
      return NinjaService.getReqBackend('php/ninja.php', {function: 'getFotoPerfil', php: 'ninja'}).then(function successCallback(response) {
        return response.data.foto;
      }, function errorCallback(response) {
          return alert("Erro:" + response);
      });
    };

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

    widget.getFriends = function() {
      
        // Note: The call will only work if you accept the permission request
      FB.api('/me/friends', function(response) {
            var friend_data = response.data;
            console.log(friend_data);
      });
      FB.api('/me/picture?width=600&height=600', function(response) {
            var friend_data = response.data;
            console.log(friend_data);
      });
    };  

    widget.verificaLogin = function(){
        FB.api('/me', function(response) {
            console.log(response);
        });
    };
    
    function setCookieLogin(id, name, acessToken) {
      document.cookie = 'ninja_id='+id;
      document.cookie = 'ninja_accessToken='+acessToken;
      document.cookie = 'ninja_name='+name;
      verificaCadastro(id).then(function successCallback(response) {
        if(response.data.cadastrado || response.data.cadastroRealizado) window.location.href = 'index.html';
        if(response.data.erroCadastro) alert("Ocorreu um erro ao realizar o login com facebook.");
      }, function errorCallback(response) {
          return alert("Erro:" + response);
      });
        /* Set cookie backend
        var REQ = { 
           url:   'php/login.php',
           type:  'POST',
           data:  {setCookieLogin: "true", idUser: id, nameUser: name, token: acessToken}
        };
        requisicaoAjax(REQ);       */
    };
    
    widget.getAmigosBackend = function() {
      NinjaService.getReqBackend("php/facebook.php", {function: 'getEmail', php: 'facebook'});
    }

    function verificaCadastro(id) {
      return NinjaService.getReqBackend('php/ninja.php', {function: 'verificaCadastro', id: id, php: 'ninja'});
    };


    // -------------------------------------- CHAMADA BACKEND ---------------------------------------------- //

     

};

NinjaController.$inject = ['$scope', 'NinjaService'];
