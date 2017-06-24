angular.module('Ninjas', [])  
.controller('NinjaController', NinjaController);

function NinjaController(widget, $http) {
    widget.itens = getDataSet();
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
    function getDataSet() {
         var REQ = { 
           url:   'php/Ninja.php',
           type:  'POST',
           data:  {}
       };
        requisicaoAjax(REQ);       
        

    };

    function setItens(data) {
        var data = [{produto: 'Leite', quantidade: 2, comprado: false},
        {produto: 'Cerveja', quantidade: 12, comprado: false}];
        return data;
    }

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
    }

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
    
    function checkLoginState() {
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    }
};

NinjaController.$inject = ['$scope', '$http'];
