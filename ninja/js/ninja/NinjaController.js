$(document).ready(function(){
	$('ul.tabs').tabs({
		swipeable: true,
		responsiveThreshold: 1920
	});
	$('.button-collapse').sideNav({
		menuWidth: 300, // Default is 300
		edge: 'left', // Choose the horizontal origin
		closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
		draggable: true
	});
	$('.carousel .carousel-slider').carousel({noWrap:true});
	var lastScrollTop = 0;
	$(window).scroll(function(event) {
		var st = $(this).scrollTop();
		if (st > lastScrollTop) {
			$('#menus').css({
				"margin-top": "-50px",
				"transition": "margin-top 0.2s"
			});
		}
		else {
			$('#menus').css({
				"margin-top": "0px",
				"transition": "margin-top 0.3s"
			});
		}
		lastScrollTop = st;
		$("#slide-out").on("swipeleft", function() {
			$('.button-collapse').sideNav('hide');
		});
		$("#test-swipe-1").on("swiperight", function() {
			$('.button-collapse').sideNav('show');
		});
	});
	$("#slide-out").on("swipeleft", function() {
		$('.button-collapse').sideNav('hide');
	});
	$("#test-swipe-1").on("swiperight", function() {
		$('.button-collapse').sideNav('show');
	});
});
angular.module('Ninja', ['ngTouch'])
	.controller('NinjaController', NinjaController);

function NinjaController(widget, NinjaService) {
	setJqueryFunctions();



	widget.getData = function() {
		NinjaService.getReqBackend('php/Ninja.php', {
			function: 'getInfoUsuario',
			php: 'ninja'
		}).then(function successCallback(response) {
			if(response.data.foto){
				this.fotoPerfil = response.data.foto;
				this.nome = response.data.nome;
				this.nickname = response.data.nickname;
				this.cover = response.data.cover;
			}else{
				this.fotoPerfil = 'imagens/default/defaultProfile.png';
				this.cover      = 'imagens/default/cutmypic.png';
				this.nickname	= '@johndoe';
				this.name		= 'John Doe';
			}
		}.bind(this), function errorCallback(response) {
			return alert("Erro:" + response);
		});
	};

	widget.OpenSideNavThroughLeftSwipe = function() {
		$('.button-collapse').sideNav('show');
	}

	widget.slideTo = function(newContent, newContentPosition) {
		var screenSize = screen.width;
		var multiplier = -1;
		var orientation = false;
		for (var index = newContentPosition; index < 4;) {
			if (index === newContentPosition) {
				$($('.tabs-content')[0].children[index]).css({
					"transform": "translateX(0px) translateX(0px) translateX(0px) translateZ(0px)"
				});
			}
			else {
				$($('.tabs-content')[0].children[index]).css({
					"transform": "translateX(0px) translateX(" + multiplier * screenSize + "px) translateZ(0px)"
				});
			}
			if (!orientation) {
				index--;
				multiplier--;
			}
			else {
				index++;
				multiplier++;
			}
			if (index < 0) {
				index = newContentPosition + 1;
				multiplier = 1;
				orientation = true;
			}
		}
	};

	widget.slideOnClick = function($event) {
		var newContentId = $event.currentTarget.children[0].hash;
		var newContent = $('' + newContentId + '');
		var newContentPosition = 0;
		$('ul.tabs').children().each(function(index, navs) {
			if (navs === $event.currentTarget)
				newContentPosition = index;
		});
		$('.carousel').carousel('set', newContentPosition);
		$('' + newContentId + '').trigger("click");

		/*
		    	if(!newContent.hasClass('active')){
		    		var oldLink = $('a.active');
		    		var oldContent = $('.carousel-item.active');
		    		oldContent.removeClass('active');
		    		oldLink.removeClass('active');
		    		newContent.addClass('active');
		    		$('.tabs-content').addClass('scrolling');
		    		widget.slideTo(newContent, newContentPosition);
		    		$('.tabs-content').removeClass('scrolling');
		       	}*/
	};

	$(".tabs li").on("tap", function(event) {
		widget.slideOnClick(event)
	});


	widget.getFeed = function() {
		return [{
			"pergunta": "E ai piranha quem é que te come?",
			"resposta": "Hur dur"
		}, {
			"pergunta": "Vamo pro cartorio?",
			"resposta": "Sim"
		}];
	};

	widget.data = widget.getData();
	widget.feed = widget.getFeed();

	function setJqueryFunctions() {
		
	};

	widget.openSwipe = function() {
		var swipe = $('#swipe');
		var swipeAction = $('#swipe > a');
		var swipePointer = $('#swipe > .swipe-pointer');
		//mobile
		if (jQuery(window).width() < 786) {
			swipe.stop().css({
				"margin-left": "0",
				width: "100%",
				heigth: "100%",
				display: "",
				top: 0
			});
			swipeAction.stop().css({
				"margin-left": "0",
				"margin-top": "2000px"
			});
			swipe.removeClass('closed');
			swipe.addClass('open');
			setVisibilityActions();
		}
		//desktop
		else {
			swipe.stop().css({
				"margin-left": "29.9%",
				heigth: "100%",
				display: "",
				top: 0
			});
			swipeAction.stop().css({
				"margin-left": "0",
			});
			swipePointer.stop().css({
				"top": "20"
			});
			swipe.removeClass('closed');
			swipe.addClass('open');
		}
	};

	function setVisibilityActions() {
		var containerAction = $('a.container-action');
		var swipe = $('#swipe');
		if (swipe.hasClass("open")) {
			containerAction.stop().css({
				"margin-left": "40%"
			});
		}
		else if (swipe.hasClass("closed")) {
			containerAction.stop().css({
				"margin-left": "-90%"
			});
		}
	};
};

NinjaController.$inject = ['$scope', 'NinjaService'];
