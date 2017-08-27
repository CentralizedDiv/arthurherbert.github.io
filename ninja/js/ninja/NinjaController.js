angular.module('Ninja', [])  
.controller('NinjaController', NinjaController);

function NinjaController(widget, NinjaService) {

    widget.getData = function(){
      NinjaService.getReqBackend('php/ninja.php', {function: 'getInfoUsuario', php: 'ninja'}).then(function successCallback(response) {
        this.fotoPerfil = response.data.foto;
        this.nome 		= response.data.nome;
      }.bind(this), function errorCallback(response) {
          return alert("Erro:" + response);
      });
    };

	widget.data       = widget.getData();

    widget.openSwipe = function(){
		var swipe = $('#swipe');
		var swipeAction = $('#swipe > a');
		var swipePointer = $('#swipe > .swipe-pointer');
		//mobile
		if(jQuery(window).width() < 786){
			swipe.stop().css({
				"margin-left":"0",
				width:"100%",
				heigth:"100%",
				display:"",
				top:0
			});
			swipeAction.stop().css({
				"margin-left":"0",
				"margin-top":"2000px"
			});
			swipe.removeClass('closed');	
			swipe.addClass('open');
			//setVisibilityActions();
		}
		//desktop
		else{
			swipe.stop().css({
				"margin-left":"29.9%",
				heigth:"100%",
				display:"",
				top:0
			});
			swipeAction.stop().css({
				"margin-left":"0",
			});
			swipePointer.stop().css({
				"top": "20"	
			});
			swipe.removeClass('closed');	
			swipe.addClass('open');
		}
	};

	function setVisibilityActions(){
		var containerAction = $('a.container-action');
		var swipe = $('#swipe');
		if(swipe.hasClass("open")){
			containerAction.stop().css({
				"margin-left":"40%"
			});
		}else if(swipe.hasClass("closed")){
			containerAction.stop().css({
				"margin-left":"-90%"
			});
		}
	};
};

NinjaController.$inject = ['$scope', 'NinjaService'];
