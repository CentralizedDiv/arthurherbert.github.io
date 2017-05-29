$(document).ready(function(){
/*Function to call ajax for contato.html's form*/
	if(location.pathname.split('/').slice(-1)[0] === 'contato.html'){
		$(".form-horizontal").find("input,textarea,select").jqBootstrapValidation(
		    {
			    preventSubmit: true,
			    submitError: function($form, event, errors) {
			    },
			    submitSuccess: function($form, event) {
			        event.preventDefault(); 
			        var formContato = {};
	                formContato.name = $("input#name").val();
	                formContato.email = $("input#email").val();
	                formContato.phone = $("input#phone").val();
	                formContato.assunto = $("select#assunto").val();
	                formContato.mensagem = $("textarea#mensagem").val();
	                var jsonContato = JSON.stringify(formContato);               
	                $.ajax({
	                    url: "php/contato.php",
	                    type: "POST",
	                    data: {dados: jsonContato},
	                    cache: false,
	                    success: function(response){
	                    	if(response === 'true'){
	                    		alert('Mensagem Enviada, aguarde sua resposta em seu email');
	                    		$('.form-horizontal').find("input, textarea").val("");
	                    		$('.form-horizontal').find("select").val("Quero ser um fornecedor");
							}
	                    },
	                    error: function(){
	                    	alert('Erro ao enviar a mensagem. Que tal ligar pra gente? (31) 3511-7175 ou (31) 3162-0030')
	                    }
	                });
			    },
			    filter: function() {
			        return $(this).is(":visible");
			    }
			}
		);
	}

/*Funtions do call each 'getDataSet*/
	$("#tabFor").on('click touch', function(){
		getDataSet('fornecedor');
	});
	$('#tabTra').on('click touch', function(){
		getDataSet('trabalheConosco');
	});
	$('#tabSug').on('click touch', function(){
		getDataSet('sugRec');
	});
	$('#tabOut').on('click touch', function(){
		getDataSet('outros');
	});

/**
  *
  * Function to call ajax to get the dataSet from the tabbed passed as parameter
  *	@param {String}: name of the tabbed that have the table to be populated
  *
 **/
	function getDataSet(tab){
		var tab = tab;
		$.ajax({
		   url:   'php/contato.php',
		   type:  'POST',
		   data:  {method: tab},
		   error: function() {
		         alert('Erro ao tentar ação!');
		   },
		   success: function(dataSet){ //Performs an async AJAX request
	       		populateAndUpdateTables(dataSet, tab);
	        }
		});
	 };

 /**
  *
  * Function to populate the tables of the tabbed passed as parameter
  *	@param {Array}: dataSet returned from backend with the contacts, 
  * {String}: name of the tabbed that have the table to be populated
  *
 **/
	function populateAndUpdateTables(dataSet, tab){
		var tab   = tab;
		var table = $('#'+ tab);
		var rows  = $('#'+ tab).find('tbody > tr');
		var headers = table.find('thead').find('th');
		headers = $.makeArray(headers);
		if($.isArray(dataSet)){
			//Get the rows of the current table and delete them to update
			var rows = $('#'+ tab).find('tbody > tr');
			rows.each(function(){
				$(this).remove();
			})
			//Sort the DataSet
			dataSet = sortDataSetAccToHeaders(dataSet, headers);
			dataSet.forEach(function(row){
				//Get the rows of the dataSet and populate the table with them
				table.find('tbody').append($('<tr>').attr('id', 'currentRow').attr('name', 'row'));
				//Build each row of the table, fields that have headers in html as visible and the rest as invisible
				$.each(row, function(field, value){
					var isVisible = false;
					headers.forEach(function(header){
						if(header.id === field){
							$('#currentRow').append($('<td>').text(value).css('display', 'table-cell').attr('id', field));
							isVisible = true;
						}
					});	
					if(!isVisible){
						$('#currentRow').append($('<td>').text(value).css('display', 'none').attr('id', field));	
					}			
				});
				$('#currentRow').removeAttr('id');		
			})	
		}
	};

/**
  *
  * Function to sort the dataSet according to the headers passed as
  * parameter, this headers are the 'th' tags from controleContato.html
  *	@param {Array}: dataSet returned from backend with the contacts, 
  * {Array}: array of headers: 'th' tags from html
  *
  * @return {Array}: dataSet sorted according to headers
  *
 **/
	function sortDataSetAccToHeaders(dataSet, headers){
		var sortedDataSet = [];
		dataSet.forEach(function(row){
			var sortedRow = {};
			headers.forEach(function(header, index){
				$.each(row, function(field, value){
					if(field === header.id){
						sortedRow[field] = value;
					}
					if(index === (headers.length -1)){
						sortedRow[field] = value;	
					}
				});
			});
			sortedDataSet.push(sortedRow);			
		});
		return sortedDataSet;
	};   

	if(location.pathname.split('/').slice(-1)[0] === 'controleContato.html'){
		/*Start with the active table populated*/
		var activeTabbed = ($.makeArray($('.tab-content > .active')))[0];
		if(activeTabbed)
			getDataSet(activeTabbed.id);
		$(document).on('click touch', 'tr', function(){
				var currentRow = $.makeArray($(this).find('td'));
				openSwipe(currentRow);
		});
		$('#swipe > a').on('click touch', function(){
				var swipe = $('#swipe');
				closeSwipe(swipe);
		});
	}

	function openSwipe(row){
		var swipe = $('#swipe');
		var swipeAction = $('#swipe > a');
		//mobile
		if(jQuery(window).width() < 786){
			swipe.stop().css({
				"margin-left":"0",
				width:"100%",
				heigth:"100%",
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
				"margin-left":"30%",
				heigth:"100%",
				"padding-bottom":'1000px',
				top:0
			});
			swipeAction.stop().css({
				"margin-left":"0",
			});
			swipe.removeClass('closed');	
			swipe.addClass('open');
			setVisibilityActions();
		}
		populateSwipe(row);
	};

	function closeSwipe(swipe){
		swipe.stop().css({
			"margin-left":"100%",
			width:"100%",
			heigth:"100%",
			top:0
		});
		swipe.removeClass('open');	
		swipe.addClass('closed');
		setVisibilityActions();
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

	function populateSwipe(row){
		var swipe        = $('#swipe');
		//filds Header and Footer
		var fieldsSHAndF = $.makeArray(swipe.find('.panel > .panel-heading > label, .panel > .panel-footer > label'));
		//filds Body
		var fieldsSB     = $.makeArray(swipe.find('.panel > .panel-body > label'));
		
		fieldsSHAndF.forEach(function fillSwipesHeaderAndFooter(field){
			row.forEach(function loopThroughCurrentRow(value){
				if(field.attributes.name.value === value.id){
					var valueField = value.textContent;
					var label = field.textContent.split(":", 1)[0]
					field.textContent = label+': '+valueField;
				}

			});
		});

		fieldsSB.forEach(function fillSwipesBody(field){
			row.forEach(function loopThroughCurrentRow(value){
				if(field.attributes.name.value === value.id){
					var type = field.attributes.type.value;
					var valueField = value.textContent;
					if(!document.getElementById('field'+value.id)){
						$('<'+type+'></'+type+'>').val(valueField).insertAfter('label[name='+field.attributes.name.value+']').attr('id', 'currentField');
						if($('#currentField').val() !== "")
							$('#currentField').prop('readonly', true)	
					}else{
						$('#field'+value.id).val(valueField).attr('id', 'currentField');;
						if($('#currentField').val() !== "")
							$('#currentField').prop('readonly', true)	
					}
					$('#currentField').attr('id', 'field'+value.id);	
				}

			});
		});
	};
});
