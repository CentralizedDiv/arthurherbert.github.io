<?php 
require 'facebook/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookJavaScriptLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphUser;

FacebookSession::setDefaultApplication('326198331145514', '9fb6b1909a72c7ab4371a638d6ede0de');

/* VERIFICA SE ESTA LOGADO */
$json = file_get_contents('php://input');
$facebook = new Facebook($json);

class Facebook{

  protected $session;

  function __construct($json){
    
      $helper = new FacebookJavaScriptLoginHelper();
      try {
        if(!isset($_COOKIE['ninja_accessToken'])) throw new Exception("Usuário não logado ou token espirado.", 1);
        $session = new FacebookSession($_COOKIE['ninja_accessToken']);
        $this->session = $session;
        $data = (array) json_decode($json);
        if($data['php'] == 'facebook') $this->$data['function']();
      }catch(FacebookRequestException $ex) {
        // When Facebook returns an error
      }catch(\Exception $ex) {
        // When validation fails or other local issues
      }

      // caso não esteja logado
      if (!$session) exit('Usuário não logado ou token expirado.');

      /* PEGA OS DADOS DO USUÁRIO */
      try {
          $response = (new FacebookRequest($session, 'GET', '/me'))->execute();
          $object = $response->getGraphObject();

          $fbid = $object->getProperty('id');
          $fbname = $object->getProperty('name');
          $fbgender = $object->getProperty('gender');

      } catch (FacebookRequestException $ex) {
        // echo $ex->getMessage();
      } catch (\Exception $ex) {
        // echo $ex->getMessage();
      }
  }
  
  public function getAmigos() {
    $response = (new FacebookRequest($this->session, 'GET', '/me/friends'))->execute();
    $friends = $response->getGraphObject()->asArray()["data"];
    $object = new stdClass();
    $object->data = $friends;
    echo json_encode($object);
  }


  // Retorna a foto de perfil do usuario atraves do id
  public function getProfilePicture($id) {
    return "http://graph.facebook.com/".$id."/picture?width=300";
  }


  // Retorna o ID, nome, email e foto de perfil
  public function getMe() {
    $response = (new FacebookRequest($this->session, 'GET', '/me?fields=id,name,email,picture'))->execute();
    $me = (array) $response->getResponse();
    $me['picture'] = (array) $me['picture'];
    $me['picture']['data'] = (array) $me['picture']['data'];
    $me['picture'] = $me['picture']['data']['url'];
    return $me;
  }

}

