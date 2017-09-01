$(document).ready(function(){
    $('ul.tabs').tabs({
      swipeable : true,
      responsiveThreshold :1920
    });
    $('.button-collapse').sideNav({
      menuWidth: 300, // Default is 300
      edge: 'left', // Choose the horizontal origin
      closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
      draggable: true, // Choose whether you can drag to open on touch screens,
      onOpen: function(el) { /* Do Stuff */ }, // A function to be called when sideNav is opened
      onClose: function(el) { /* Do Stuff */ }, // A function to be called when sideNav is closed
    });
    $('.carousel.carousel-slider').carousel({fullWidth: true, noWrap:true});
    var lastScrollTop = 0;
	$(window).scroll(function(event){
	   var st = $(this).scrollTop();
	   if (st > lastScrollTop){
	       $('#menus').css({
	       		"margin-top":"-50px",
	       		"transition": "margin-top 0.2s"
	       });
	   } else {
	      $('#menus').css({
	       		"margin-top":"0px",
	       		"transition": "margin-top 0.3s"
	       });
	   }
	   lastScrollTop = st;
	});
	$( "#test-swipe-1" ).on( "swiperight", function(){
    	$('.button-collapse').sideNav('show');	
    });
    $( "#slide-out" ).on( "swipeleft", function(){
    	$('.button-collapse').sideNav('hide');	
    });
});
angular.module('Ninja', ['ngTouch'])  
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

    widget.OpenSideNavThroughLeftSwipe = function(){
    	$('.button-collapse').sideNav('show');	
    }

    widget.moveIndicator = function(position){
    	var fullWidth = screen.width / 1.35;
    	var left = 0;
    	var right = 0;
    	switch (position){
    		case 1 :
    			left  = fullWidth;
    			right = 0;
    			break;
    		case 2 :
    			left  = fullWidth / 1.5;
    			right = fullWidth - left;
    			break;
    		case 3 :
    			right = fullWidth / 1.5;
    			left  = fullWidth - right;
    			break;
    		case 4 :
    			left  = 0;
    			right = fullWidth;	
    			break;
    	}
    	$('.indicator')[0].style.left = left;
    	$('.indicator')[0].style.right = right;
    }


    widget.slideOnClick = function($event){
    	var newContentId = $event.currentTarget.hash;
    	var newContent   = $(newContentId);
    	var newContentPosition = 0;
    	$('ul.tabs').each(function(index, navs){
    		if(navs.children[0] === $event.currentTarget)
    			newContentPosition = index+1;
    	});

    	if(!newContent.hasClass('active')){
    		var oldContent = $('li .active');
    		oldContent.removeClass('active');
    		newContent.addClass('active');
    		widget.moveIndicator(newContentPosition);
    		widget.slide
       	}
    }
	

    widget.getFeed = function() {
    	return [{"pergunta": "E ai piranha quem é que te come?", "resposta": "Hur dur"}, {"pergunta": "Vamo pro cartorio?", "resposta": "Sim"}];
    };

	widget.data       = widget.getData();
	widget.feed  	  = widget.getFeed();

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
			setVisibilityActions();
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
