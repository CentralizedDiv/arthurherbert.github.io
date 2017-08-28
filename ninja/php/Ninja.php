<?php 
require_once("facebook.php");
$json = file_get_contents('php://input');
$ninja = new ninja($json);


class ninja {
	protected $link;
	protected $json;

	function __construct($json){
        $this->link = new mysqli('localhost', 'root', '', 'ninja');
        $this->json = $json;
        $data = (array) json_decode($json);
		$id = isset($data['id']) ? $data['id'] : $_COOKIE['ninja_id'];;
		if($data['php'] == 'ninja') {
			$this->$data['function']($id);
		}
    }

	public function verificaLogin() {	
		return isset($_COOKIE['ninja_accessToken']);
	}

    /* Verifica se o usuario já foi cadastrado
    	na base do ninja e redireciona para tela adequada

     	@param {string} id -> ID de usuario do facebook
	*/
	public function verificaCadastro($id) {
		$consultaCadastro = $this->consultaCadastro($id);
		// Caso o usuario seja cadastrado redireciona para o index
		if($consultaCadastro) {
			$object = new stdClass();
			$object->cadastrado = true;
			echo json_encode($object);
		}
		// Caso não esteja cadastrado realiza o cadastro
			// Futuramente redirecionara para tela de cadastro passando 
			// informações do facebook
		else if($this->realizarCadastroBanco()) { 
			$object = new stdClass();
			$object->cadastroRealizado = true;
			echo json_encode($object);
		}
		else {
			$object = new stdClass();
			$object->erroCadastro = true;
			echo json_encode($object);
		}
	}

	public function getInfoUsuario($id) {
		$usuario = $this->consultaCadastro($id);
		$object = new stdClass();
		$object->foto = $usuario['FOTOUSUARIO'];
		$object->nome = $usuario['NOMEUSUARIO'];
		echo json_encode($object);
	}

	// Consulta se o login do usuario feito pelo facebook já 
    // foi registrado na base do ninja
	public function consultaCadastro($id) {
		$query = "SELECT * FROM `usuarios` WHERE `IDUSUARIOFB` = '$id'";
		$resulBanco = mysqli_query($this->link, $query);
		$row = mysqli_fetch_array($resulBanco);
		
		if($row) return $row;
		else return false;
	}


	// Realiza cadastra de usuario na base do ninja para usuario do facebook
	public function realizarCadastroBanco() {
 		$facebook = new Facebook($this->json);
 		$me = $facebook->getMe();
 		
 		$id = $me['id'];
 		$nome = $me['name'];
 		$email = $me['email'];
 		$fotoPerfil = $me['picture'];

 		$insert = "INSERT INTO `usuarios`(`IDUSUARIO`, `IDUSUARIOFB`, `EMAIL`, `NOMEUSUARIO`, `SENHAUSUARIO`, `FOTOUSUARIO`) VALUES ('$id','$id', '$email', '$nome', '123456', '$fotoPerfil')";
 		return mysqli_query($this->link, $insert);
	}
}