angular.module('Ninja', [])  
.controller('NinjaController', NinjaController);

function NinjaController(widget, NinjaService) {

    widget.fotoPerfil = getImagemPerfil();

    function getImagemPerfil() {
      return NinjaService.getReqBackend('php/ninja.php', {function: 'getFotoPerfil', php: 'ninja'}).then(function successCallback(response) {
        return response.data.foto;
      }, function errorCallback(response) {
          return alert("Erro:" + response);
      });
    };
};

NinjaController.$inject = ['$scope', 'NinjaService'];
