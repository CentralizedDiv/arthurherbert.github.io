<?php
class NinjaFacebookConnect{

/**
  *
  * Function to get he contacts from database 
  *	param {String}: code to filter the query by type of contact
  *
 **/

	public function getDataTable($assunto) {
		//LINK QUEBRADASSO
		//$link = new mysqli('mysql.hostinger.com.br', 'u832569433_arpe', 'SekA9KkSrt7U', 'u832569433_padar');

		$link = new mysqli('localhost', 'root', '', 'padaria');
		$query = "SELECT * FROM `contatos` WHERE `CDTIPCON` = '$assunto' ORDER BY `NRSEQUE` DESC";
		$resulBanco = mysqli_query($link, $query);
		$result = [];
		if($resulBanco) {
		    while ($row = mysqli_fetch_array($resulBanco)) { // fetches a result row as an  array
		        //create an Object with each row returned
		        $object = new stdClass();
		        $object->ASSUNTO  = $row['ASSUNTO'];
		        $object->EMAIL 	  = $row['EMAIL'];
		        $object->DTCONTA  = $row['DTCONTA'] ;
		        $object->NRSEQCON = $row['NRSEQCON'];
		        $object->NRSEQUE  = $row['NRSEQUE']; 
		        $object->NOMECLIE = $row['NOMECLIE'];
		        $object->MENSAGEM = $row['MENSAGEM'];
		        $object->CDTIPCON = $row['CDTIPCON'];
		        $object->TELEFONE = $row['TELEFONE'];
		        $object->DTRESPO  = $row['DTRESPO'] ;
		        $object->CDOPERA  = $row['CDOPERA'] ;
		        $object->RESPOSTA  = $row['RESPOSTA'] ;
		        $result[] = $object;
		    }
		}
    	mysqli_close($link); // close connection with database
    	header('Content-Type: application/json');
    	return $result;
	}	



	//----------------------------------------------------------------------------//

}
?>