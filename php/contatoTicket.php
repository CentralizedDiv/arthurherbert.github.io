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
		// Prepara a row para inserção no banco de dados
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
				$row['ASSUNTO'] = 'SUGREG';
				$row['CDTIPCON'] = 3;
				break;
			case 'Outros':
				$row['ASSUNTO'] = 'OUTROS';
				$row['CDTIPCON'] = 4;
				break;
		}
		$codigos = $this->geraCodigo($row['ASSUNTO'], $row);
		$row['NRSEQCON'] = $codigos['NRSEQCON'];
		$row['NRSEQUE']  = $codigos['NRSEQUE'];
		$row['DTCONTA']  = date("d/m/Y");
		// Insere no banco de dados e retorna $resulBanco que é um boolean onde diz se a inserção deu certo
		$resulBanco = $this->insertBanco($row['NRSEQCON'], $row['NOMECLIE'], $row['EMAIL'], $row['ASSUNTO'], $row['TELEFONE'], 
			$row['MENSAGEM'], $row['NRSEQUE'], $row['DTCONTA'], '', $row['CDTIPCON'], '0001');
		
		return $resulBanco;
	}


	//----------------------------------------------------------------------------//

	// Inser no banco os dados do contato
	protected function insertBanco($NRSEQCON, $NOMECLIE, $EMAIL, $ASSUNTO, $TELEFONE, $MENSAGEM, $NRSEQUE, $DTCONTA,
		$DTRESPO, $CDTIPCON, $CDOPERA) {

		$link = new mysqli('localhost', 'root', '', 'padaria');
		$query = "INSERT INTO `contatos`(`NRSEQCON`, `NOMECLIE`, `EMAIL`, `ASSUNTO`, `TELEFONE`, `MENSAGEM`, `NRSEQUE`, `DTCONTA`, `CDTIPCON`, `CDOPERA`) VALUES ('$NRSEQCON', '$NOMECLIE', '$EMAIL', '$ASSUNTO', '$TELEFONE', '$MENSAGEM', '$NRSEQUE', STR_TO_DATE('$DTCONTA', '%d/%m/%Y'), '$CDTIPCON', '$CDOPERA')";
		$resulBanco = mysqli_query($link, $query);
		return $resulBanco;
		
	}

	// Gera os códigos sequencias para inserção no banco de dados 'contatos' e os grava no banco newCode
	protected function geraCodigo($primaryKey) {
		
	
		$link = new mysqli('localhost', 'root', '', 'padaria');
		// Busca todos os codigos sequencias na tabela newCode para aquele tipo de contato
		$queryTipoContato = "SELECT * FROM newcode WHERE TABLEPK = '$primaryKey' ORDER BY NRSEQUENCIAL ASC";
		$resultTipoContato = mysqli_query($link, $queryTipoContato); 

		// Busca todos os codigos sequencias na tabela newCode
		$query = "SELECT * FROM newcode WHERE TABLEPK = 'CONTATO' ORDER BY NRSEQUENCIAL ASC";
		$resultado = mysqli_query($link, $query);

		// Inicializa variaveis do codigo sequencial maximo
		$sequencialMax = 0;
		$sequencialMaxTipoContato = 0;

		// Verifica se existe algum codigo no banco para aquele tipo de Contato
		if(mysqli_num_rows($resultTipoContato) != 0){
			// Caso exista descobre qual o ultimo codigo
			$stop = false; // Variavel que indica a hora de parar
			// Percorre o vetor do resultado
			foreach ($resultTipoContato as $key => $value) {
				// Verifica se o codigo sequencial é maior que o maximo e se não é hora de parar
				if($value['NRSEQUENCIAL'] > $sequencialMaxTipoContato && $stop === false) {
					// Verifica se a diferença entre o sequencial atual e o sequencial Maximo é de 1 se for 
					// torna o sequencial atual como maximo temporariamente 
					if(intval($value['NRSEQUENCIAL']) - 1 === $sequencialMaxTipoContato) {	
						$sequencialMaxTipoContato = intval($value['NRSEQUENCIAL']);
					}
					// Se a diferença for maior do que um define que é a hora de parar e coloca o atual como
					// definitivamente mesmo que haja outros elementos no vetor(Isso acontece quando há saltos
					// de codigo exemplo 01 e depois 03)
					else if(intval($value['NRSEQUENCIAL']) - $sequencialMaxTipoContato > 1){
						$stop = true;
					}
					else {
						$sequencialMaxTipoContato = intval($value['NRSEQUENCIAL']) + 1;
						$stop = true;
					}
				}
			}
		}
		else {
			$sequencialMaxTipoContato = 0;
		}

		if(mysqli_num_rows($resultado) != 0) {
			$stop2 = false;
			foreach ($resultado as $key => $value) {
				if(intval($value['NRSEQUENCIAL']) > $sequencialMax && $stop2 === false) {
					if($value['NRSEQUENCIAL'] - 1 === $sequencialMax) {
						$sequencialMax = intval($value['NRSEQUENCIAL']);
					}
					else if(intval($value['NRSEQUENCIAL']) - $sequencialMax > 1){
						$stop = true;
					}
					else {
						$sequencialMax = intval($value['NRSEQUENCIAL']) + 1;
						$stop2 = true;
					}
				}
			}
		}
		else {
			$sequencialMax = 0;
		} 

		
		$sequencialTipoContato = $sequencialMaxTipoContato + 1; // acrescenta 1 ao maximo
		$sequencial = $sequencialMax + 1;	// acrescenta 1 ao maximo
		$sequencialLength = 11 - strlen($sequencial);
		$sequencialTipoContatoLength = 5 - strlen($sequencialTipoContato); 
		$sequencial = str_pad($sequencial, $sequencialLength, "0", STR_PAD_LEFT); // formata
		$sequencialTipoContato = str_pad($sequencialTipoContato, $sequencialTipoContatoLength, "0", STR_PAD_LEFT); // formata
		$codigos = array("NRSEQCON" => $sequencial, "NRSEQUE" => $sequencialTipoContato);
		$insert = "INSERT INTO `newcode`(`NRSEQUENCIAL`, `TABLEPK`) VALUES ('$sequencial','CONTATO')"; 
		mysqli_query($link, $insert);
		$insertContato = "INSERT INTO `newcode`(`NRSEQUENCIAL`, `TABLEPK`) VALUES ('$sequencialTipoContato','$primaryKey')";
		mysqli_query($link, $insertContato); 

		return $codigos;

	}
}
?>