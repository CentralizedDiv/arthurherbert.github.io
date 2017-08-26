angular.module('Ninjas', [])  
.controller('NinjaController', NinjaController);

function NinjaController(widget, $http) {
    widget.FBLogin = function() {
      FB.login(function(response){
        if(response.authResponse) {
          FB.api('/me', function(response) {
            console.log('DEU BOM DEMAIS');
            console.log(response);
            var acessToken = FB.getAuthResponse();
            console.log(acessToken);
          });
        }
        else {
          console.log('DEU RUIM');
        }

      }, {scope: 'public_profile,email,user_friends'});
    };
    widget.testPublication = function() {
      
        // Note: The call will only work if you accept the permission request
      FB.api('/me/friends', function(response) {
            var friend_data = response.data;
            console.log(friend_data);
        });
    };  
    
    function getDataSet() {
         var REQ = { 
           url:   'php/Ninja.php',
           type:  'POST',
           data:  {}
       };
        requisicaoAjax(REQ);       
    };

    function requisicaoAjax(REQ) {
        $http(REQ).success(function(data){
           setItens(data);
        }.bind(this))
        .error(function(err){
          console.log('Erro: ', err);
        });
    };

};

NinjaController.$inject = ['$scope', '$http'];
