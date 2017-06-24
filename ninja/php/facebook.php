<?php 
require_once("facebookLogin.php");
$ticket = new NinjaFacebookConnect();
$contato = new Ninja($ticket);


$contato->getContatoFornecedor();

    

class Ninja{
    protected $ticket;
    function __construct($ticket){
        $this->ticket = $ticket;
    }
    function getContatoFornecedor() { 
        $result = $this->ticket->getDataTable(1);
        echo json_encode($result);
        return $result;
    }

}
?>
