$(document).ready(function(){
/*Functions do call each 'getDataSet*/
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
	        },
		   beforeSend: function() {
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
		var tab = tab;
		var rows = $('#'+ tab).find('tbody > tr');
		if($.isArray(dataSet)){
			//get the rows of the current table and delete them
			var rows = $('#'+ tab).find('tbody > tr');
			rows.each(function(){
				$(this).remove();
			})
			dataSet.forEach(function(row){
				//get the rows of the dataSet and populate the table with them
				$('#'+ tab).find('tbody').append($('<tr>').attr('id', 'currentRow'));
				$.each(row, function(field, value){
					$('#currentRow').append($('<td>').text(value));	
				})
				$('#currentRow').removeAttr('id');		
			})	
		}
	}

});

