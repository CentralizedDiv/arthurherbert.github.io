<?php 
require_once("redirectLogin.php");
$json = file_get_contents('php://input');
$ninja = new ninja($json);


class ninja {
	protected $link;
	protected $json;

	function __construct($json){
        $this->link = new mysqli('localhost', 'root', '', 'ninja');
        $this->json = $json;
        $data = (array) json_decode($json);
        if($data['function'] === 'cadastrar') {
        	if($data['php'] == 'ninja') $this->$data['function']($data['me']);
        }
        else if($data['function'] === 'login') $this->$data['function']($data['user'], $data['password']);
        else {
			$id = isset($data['id']) ? $data['id'] : $_COOKIE['ninja_id'];;
			if($data['php'] == 'ninja') $this->$data['function']($id);
		}
    }

	protected function verificaLogin() {	
		return isset($_COOKIE['ninja_accessTokenFB']);
	}

	public function login($usuario, $senha) {
		$row = $this->consultaCadastro($usuario, $senha);
		if($row) {
			if($row['SENHAUSUARIO'] == $senha) {
				$this->setcookieLogin($row['IDUSUARIO'], $row['NOMEUSUARIO']);
			}
			else {
				$object = new stdClass();
				$object->senhaincorreta = true;
				echo json_encode($object);
			}
		}
		else {
			$object = new stdClass();
			$object->naocadastrado = true;
			echo json_encode($object);
		}
	}
	

    /* Verifica se o usuario já foi cadastrado
    	na base do ninja e redireciona para tela adequada

     	@param {string} id -> ID de usuario do facebook
	*/
	protected function verificaCadastroFacebook($id) {
		$consultaCadastro = $this->consultaCadastroFacebook($id);
		// Caso o usuario seja cadastrado redireciona para o index
		if($consultaCadastro) {
			$object = new stdClass();
			$object->cadastrado = true;
			echo json_encode($object);
		}
		// Caso não esteja cadastrado realiza o cadastro
			// Futuramente redirecionara para tela de cadastro passando 
			// informações do facebook
		else if($consultaCadastro === false)  {
			$object = new stdClass();
			$object->cadastrado = false;
			echo json_encode($object);
		}
		else {
			$object = new stdClass();
			$object->erroCadastro = true;
			echo json_encode($object);
		}
	}


	protected function getInfoUsuario($id) {
		$usuario = $this->verificaId($id);
		$object = new stdClass();
		$object->foto = $usuario['FOTOUSUARIO'];
		$object->nome = $usuario['NOMEUSUARIO'];
		$object->nickname = $usuario['NICKNAME'];
		$object->cover = $usuario['FOTOCAPA'];
		echo json_encode($object);
	}

	protected function cadastrar($me) {
		$me = (array) $me;
		if(isset($_COOKIE['ninja_idFB'])) {
			if(!$this->verificaId($_COOKIE['ninja_idFB'])) {
				$me['id']   = $_COOKIE['ninja_idFB'];
				$me['idFB'] = $_COOKIE['ninja_idFB'];
			}
			else {
				$me['id'] = $this->geraId();
				$me['idFB'] = $this->geraId();
			}
		}
		else {
			$me['id'] = $this->geraId();
			$me['idFB'] = $this->geraId();
		}
		$object = new stdClass();
		$result = $this->realizarCadastroBanco($me);
		if($result) {
			$this->setcookieLogin($me['id'], $me['nome']);
		}
		$object->cadastrado = $result;
		echo json_encode($object);
		
	}

	private function setcookieLogin($id, $nome) {
		setcookie('ninja_id', $id);
    	setcookie('ninja_name', $nome);
	}

	private function geraId() {
		return "312321412";
	}

	private function consultaCadastro($usuario, $senha) {
		$query = "SELECT * FROM `usuarios` WHERE `EMAIL` = '$usuario' OR `NOMEUSUARIO` = '$usuario' OR `NICKNAME` = '$usuario'";
		$resulBanco = mysqli_query($this->link, $query);
		$row = mysqli_fetch_array($resulBanco);
		if(isset($row[0])) {
			return $row;
		}
		else return false;
			
	}

	// Consulta se o login do usuario feito pelo facebook já 
    // foi registrado na base do ninja
	private function consultaCadastroFacebook($id) {
		$query = "SELECT * FROM `usuarios` WHERE `IDUSUARIOFB` = '$id'";
		$resulBanco = mysqli_query($this->link, $query);
		$row = mysqli_fetch_array($resulBanco);
		
		if($row) return $row;
		else return false;
	}

	private function verificaId($id) {
		$query = "SELECT * FROM `usuarios` WHERE `IDUSUARIO` = '$id'";
		$resulBanco = mysqli_query($this->link, $query);
		$row = mysqli_fetch_array($resulBanco);
		
		if($row) return $row;
		else return false;
	}

	// Realiza cadastra de usuario na base do ninja para usuario do facebook
	private function realizarCadastroBanco($me) {
 		$id = $me['id'] ? $me['id'] : '';
 		$idFB = $me['idFB'] ? $me['idFB'] : '';
 		$nome = $me['nome'] ? $me['nome'] :  '';
 		$bio  = $me['bio']  ? $me['bio']  :  '';
 		$password = $me['password'] ? $me['password'] : 'DASDQWDASdaqsdqw312dfD1231dfSFGNADNMIQWEUQIW0UPOKKÇ109';
 		$email = $me['email'] ? $me['email'] : '';
 		$fotoCapa = $me['cover'] ? $me['cover'] : '';
 		$fotoPerfil = $me['picture'] ? $me['picture'] : '';
 		$nickname = $me['nickname']  ? $me['nickname'] : '';

		$nickname = str_replace('@', '', $nickname);
		$nickname = '@'.$nickname;

 		$insert = "INSERT INTO `usuarios`(`IDUSUARIO`, `IDUSUARIOFB`, `EMAIL`, `NOMEUSUARIO`, `SENHAUSUARIO`, `FOTOUSUARIO`, `SINCRONIZADO`, `FOTOCAPA`, `BIO`, `NICKNAME`) VALUES ('$id','$idFB','$email','$nome','$password','$fotoPerfil','S','$fotoCapa','$bio', '$nickname')";
 		
 		return mysqli_query($this->link, $insert);
	}
}