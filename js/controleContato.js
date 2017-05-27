$(document).ready(function(){
/*Start with the active table populated*/
	var activeTabbed = ($.makeArray($('.tab-content > .active')))[0];
	getDataSet(activeTabbed.id)

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
			dataSet.forEach(function(row){
				//Get the rows of the dataSet and populate the table with them
				table.find('tbody').append($('<tr>').attr('id', 'currentRow'));
				//Build each row of the table, fields that have headers in html as visible and the rest as invisible
				$.each(row, function(field, value){
					var isVisible = false;
					headers.forEach(function(header){
						if(header.id === field){
							$('#currentRow').append($('<td>').text(value).css('display', 'table-cell'));
							isVisible = true;
						}
					});	
					if(!isVisible){
						$('#currentRow').append($('<td>').text(value).css('display', 'none'));	
					}			
				});
				$('#currentRow').removeAttr('id');		
			})	
		}
	}

});

