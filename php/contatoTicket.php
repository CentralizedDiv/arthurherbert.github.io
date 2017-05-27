<?php
class ContatoTicket{

/**
  *
  * Function to get the contacts from database 
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
		        $object->CDTIPCON = $row['CDTIPCON'];
		        $object->NRSEQUE = $row['NRSEQUE'];
		        $object->NRSEQCON = $row['NRSEQCON'];
		        $object->ASSUNTO = $row['ASSUNTO'];
		        $object->DTCONTA = $row['DTCONTA'];
		        $object->DTRESPO = $row['DTRESPO'];
		        $object->CDOPERA = $row['CDOPERA'];
		        $result[] = $object;
		    }
		}
    	mysqli_close($link); // close connection with database
    	header('Content-Type: application/json');
    	return $result;
	}	

	public function saveContato($row) {
		switch ($row['ASSUNTO']) {
			case 'Quero ser um fornecedor':
				$row['ASSUNTO']  = 'FORNCEDOR';
				$row['CDTIPCON'] = 1;
				break;
			case 'Trabalhe Conosco':
				$row['ASSUNTO'] = 'TRABALHE';
				$row['CDTIPCON'] = 2;
				break;
			case 'Sugestão/Reclamação':
				$row['ASSUNTO'] = 'SUGREG'
				$row['CDTIPCON'] = 3;
				break;
			case 'Outros':
				$row['ASSUNTO'] = 'OUTROS'
				$row['CDTIPCON'] = 4;
				break;
		}
		$codigos = $this->geraCodigo($row['ASSUNTO'], $row);
		$row['NRSEQCON'] = $codigos['NRSEQCON'];
		$row['NRSEQUE']  = $codigos['NRSEQUE'];
		$this->insertBanco($row['NRSEQCON'], $row['NOMECLIE'], $row['EMAIL'], $row['ASSUNTO'], $row['TELEFONE'], 
			$row['MENSAGEM'], $row['NRSEQUE'], $row['DTCONTA'], NULL, $row['CDTIPCON'], '0001');
		$link = new mysqli('localhost', 'root', '', 'padaria');
		$query = "SELECT * FROM `contatos` WHERE `CDTIPCON` = '$assunto' ORDER BY `NRSEQUE` DESC";
		$resulBanco = mysqli_query($link, $query);
		return $resulBanco;
	}


	//----------------------------------------------------------------------------//

	protected function insertBanco($NRSEQCON, $NOMECLIE, $EMAIL, $ASSUNTO, $TELEFONE, $MENSAGEM, $NRSEQUE, $DTCONTA,
		$DTRESPO, $CDTIPCON, $CDOPERA) {
		$query = "INSERT INTO `contatos`(`NRSEQCON`, `NOMECLIE`, `EMAIL`, `ASSUNTO`, `TELEFONE`, `MENSAGEM`, `NRSEQUE`, `DTCONTA`, `DTRESPO`, `CDTIPCON`, `CDOPERA`) VALUES ('$NRSEQCON', '$NOMECLIE', '$EMAIL', '$ASSUNTO', '$TELEFONE', '$MENSAGEM', '$NRSEQUE', '$DTCONTA', '$DTRESPO', '$CDTIPCON', '$CDOPERA')";
		$
	}

	protected function geraCodigo($primaryKey) {
		
	//$link = new mysqli('mysql.hostinger.com.br', 'u832569433_arpe', 'JaQs1Jf8nyBn', 'u832569433_padar');
		$link = new mysqli('localhost', 'root', '', 'dbPadaria');
		$queryTipoContato = "SELECT * FROM newcode WHERE TABLEPK = '$primaryKey' ORDER BY NRSEQUENCIAL ASC";
		$resultTipoContato = mysqli_query($link, $queryTiposContato); 

		$query = "SELECT * FROM newcode WHERE TABLEPK = 'CONTATO'";
		$resultado = mysqli_query($link, $query);

		$sequencialMax = 0000000000;
		$sequencialMaxTipoContato = 0000;
		$stop = false; 
		foreach ($resultTipoContato as $key => $value) {
			if($value['NRSEQUENCIAL'] > $sequencialMaxTipoContato && $stop === false) {
				if($value['NRSEQUENCIAL'] - 1 === $sequencialMaxTipoContato) {
					$sequencialMaxTipoContato = $value['NRSEQUENCIAL'];
				}
				else {
					$sequencialMaxTipoContato = $value['NRSEQUENCIAL'] + 1;
					$stop = true;
				}
			}
		}
		foreach ($resultado as $key => $value) {
			if($value['NRSEQUENCIAL'] > $sequencialMax && $stop === false) {
				if($value['NRSEQUENCIAL'] - 1 === $sequencialMax) {
					$sequencialMax = $value['NRSEQUENCIAL'];
				}
				else {
					$sequencialMax = $value['NRSEQUENCIAL'] + 1;
					$stop = true;
				}
			}
		}
		$sequencialTipoContato = $sequencialMaxTipoContato + 1;
		$sequencial = $sequencialMax + 1;

		$codigos = array("NRSEQCON" = $sequencial, "NRSEQUE" $sequencialTipoContato);

		$insert = "INSERT INTO newcode(TABLEPK, NRSEQUENCIAL) VALUES ('CONTATO', '$sequencial'" or die("Error in the consult.." . mysqli_error($link)); 
		mysqli_query($link, $queryContato);
		$insertContato = "INSERT INTO newcode(TABLEPK, NRSEQUENCIAL) VALUES ('$primaryKey', '$sequencialTipoContato'" or die("Error in the consult.." . mysqli_error($link);
		mysqli_query($link, $queryContato); 

		return $codigos;

	}
}
?>