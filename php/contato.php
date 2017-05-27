<?php 
require_once("contatoTicket.php");
$ticket = new ContatoTicket();
$contato = new Contato($ticket);
//Verify if ajax pass the method and choose what parameter pass to the query
if(isset($_POST['method']) && !empty($_POST['method'])) {
    $method = $_POST['method'];
    switch($method) {
        case 'fornecedor' : $contato->getContatoFornecedor();break;
        case 'trabalho'   : $contato->getContatoTrabalho();break;
        case 'sugrec'     : $contato->getContatoSugRec();break;
        case 'outros'     : $contato->getContatoOutros();break;
    }
}
class Contato{
    protected $ticket;
    function __construct($ticket){
        $this->ticket = $ticket;
    }
    function getContatoFornecedor() { 
        return $this->ticket->getDataTable('1');
    }

    function getContatoTrabalho() {
        return $this->ticket->getDataTable('2');
    }

    function getContatoSugRec() {
        return $this->ticket->getDataTable('3');
    }

    function getContatoOutros() {
        return $this->ticket->getDataTable('4');
    }
}


?>
