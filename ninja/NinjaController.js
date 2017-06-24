angular.module('Ninjas', [])  
.controller('NinjaController', NinjaController);

function NinjaController(widget, $http) {
    widget.itens = getDataSet();
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

    widget.adicionaItem = function () {
        widget.itens.push({produto: widget.item.produto,
                           quantidade: widget.item.quantidade,
                           comprado: false});
        widget.item.produto = widget.item.quantidade = '';
    };
    widget.removeItem = function () {
        widget.itens.pop();
    };
};

NinjaController.$inject = ['$scope', '$http'];
