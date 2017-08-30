<?php
$json = file_get_contents('php://input');
$data = (array) json_decode($json);
if($data['php'] == 'redirectLogin') {
	verificaLogin($json, $data['token'], $data['idFB'], $data['nome']);
}

function verificaLogin($json, $accessToekn, $id, $nome) {
	if(!getStatusLogin()) {
	    setcookie('ninja_accessToken', $accessToekn);
	    setcookie('ninja_id', $id);
	    setcookie('ninja_name', $nome); 
	}
}

function getStatusLogin() {	
    return isset($_COOKIE['ninja_accessToken']);
}
