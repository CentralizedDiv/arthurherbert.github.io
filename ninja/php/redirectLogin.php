<?php
$json = file_get_contents('php://input');
$data = (array) json_decode($json);
if($data['php'] == 'redirectLogin') {
	$data['function']($json, $data['token'], $data['idFB'], $data['nome']);
}

function verificaLogin($json, $accessToekn, $id, $nome) {
    setcookie('ninja_id', $id);
    setcookie('ninja_name', $nome); 
}

function verificaLoginFacebook($json, $accessToekn, $id, $nome) {
	setcookie('ninja_idFB', $id);
    setcookie('ninja_accessTokenFB', $accessToekn);
}


function getStatusLogin() {	
    return isset($_COOKIE['ninja_id']);
}

function getStatusLoginFacebook() {	
    return isset($_COOKIE['ninja_accessTokenFB']);
}
