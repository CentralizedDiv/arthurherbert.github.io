<?php
class ContatoTicket{

	private link = new mysqli('mysql.hostinger.com.br', 'u832569433_arpe', 'JaQs1Jf8nyBn', 'u832569433_padar');

	public function getDataTable($assunto) {
		$query = "SELECT * FROM `contatos` WHERE `CDTIPCON` = '$assunto' ORDER BY `NRSEQUE` DESC";
		$result = mysqli_query($this->link, $query); 
		return mysqli_fetch_array($result);
	}	

	public function saveContato($row) {
		$this->geraCodigo($row['ASSUNTO'], $row);
	}


	//----------------------------------------------------------------------------//
	protected function geraCodigo($primaryKey) {
		$queryContato = "SELECT * FROM newcode WHERE TABLEPK = '$primaryKey' ORDER BY NRSEQUENCIAL ASC";
		$resultTipoContato = mysqli_query($this->link, $queryContato); 

		$query = "SELECT * FROM newcode WHERE TABLEPK = 'CONTATO'";
		$resultado = mysqli_query($this->link, $queryContato);

		$sequencialMax = 0000000000;
		$sequencialMaxContato = 0000000000;
		$stop = false; 
		foreach ($resultTipoContato as $key => $value) {
			if($value['NRSEQUENCIAL'] > $sequencialMaxContato && $stop === false) {
				if($value['NRSEQUENCIAL'] - 1 === $sequencialMaxContato) {
					$sequencialMaxContato = $value['NRSEQUENCIAL'];
				}
				else {
					$sequencialMaxContato = $value['NRSEQUENCIAL'] + 1;
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
		$sequencialContato = $sequencialMaxContato + 1;
		$sequencial = $sequencialMax + 1;

		$insert = "INSERT INTO newcode(TABLEPK, NRSEQUENCIAL) VALUES ('CONTATO', '$sequencialContato'" or die("Error in the consult.." . mysqli_error($this->link)); 
		$resultTipoContato = mysqli_query($this->link, $queryContato);
		$insertContato = $this->getQuery('INSERENEWCODEPARAM'); 
		$resultTipoContato = mysqli_query($this->link, $queryContato); 

	}

	protected function getQuery($nome) {
		$query = array(
			"INSERENEWCODEPARAM" => "INSERT INTO newcode(TABLEPK, NRSEQUENCIAL) VALUES ('$primaryKey', '$sequencial'" or die("Error in the consult.." . mysqli_error($this->link));
		);
		return $query[$nome];
	}

}
?>