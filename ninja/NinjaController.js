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

      });
    };
    widget.itens = getDataSet();
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

    function setItens (data) {
        widget.itens = data;
    };

    widget.adicionaItem = function () {
        widget.itens.push({ASSUNTO: widget.item.assunto});
    };
    widget.removeItem = function () {
        widget.itens.pop();
    };

};

NinjaController.$inject = ['$scope', '$http'];
