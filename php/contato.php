<?php 
require_once("contatoTicket.php");
$ticket = new ContatoTicket();
$contato = new Contato($ticket);
//Verify if ajax pass the method and choose what parameter pass to the query

if(isset($_POST['dados'])){
    $dados = json_decode($_POST['dados']);
    if(empty($dados->name) 
        || empty($dados->email)       
        || empty($dados->assunto)     
        || empty($dados->mensagem)
        || empty($dados->phone) 
        || !filter_var($dados->email,FILTER_VALIDATE_EMAIL)) {
                echo "Existem campos em branco!";
                return false;
    }
    else if(!$contato->validarCelular($_POST['phone'])) {
        echo "Numero de celular invalido";
        return false;
    }
    else {
        $rowSave = array(
            "NOMECLIE"  =>  $dados->name,
            "EMAIL"     =>  $dados->email,
            "ASSUNTO"   =>  $dados->assunto,  
            "MENSAGEM"  =>  $dados->mensagem,
            "TELEFONE"  =>  $dados->phone
        );
        $contato->saveContato($dados);
    }


}

else if(isset($_POST['method']) && !empty($_POST['method'])) {
    $method = $_POST['method'];
    switch($method) {
        case 'fornecedor'     : $contato->getContatoFornecedor();break;
        case 'trabalheConosco': $contato->getContatoTrabalho();break;
        case 'sugRec'         : $contato->getContatoSugRec();break;
        case 'outros'         : $contato->getContatoOutros();break;
    }
}
class Contato{
    protected $ticket;
    function __construct($ticket){
        $this->ticket = $ticket;
    }
    function getContatoFornecedor() { 
        $result = $this->ticket->getDataTable(1);
        echo json_encode($result);
        return $result;
    }

    function getContatoTrabalho() {
       $result = $this->ticket->getDataTable(2);
        echo json_encode($result);
        return $result;
    }

    function getContatoSugRec() {
        $result = $this->ticket->getDataTable(3);
        echo json_encode($result);
        return $result;
    }

    function getContatoOutros() {
        $result = $this->ticket->getDataTable(4);
        echo json_encode($result);
        return $result;
    }

    function saveContato($dados) {
        if(isset($dados->resposta)){
            $rowSave = array(
                "NRSEQCON" => $dados->NRSEQCON,
                "RESPSOTA" => $dados->resposta
            );
            $sucesso = $this->ticket->updateContato($rowSave);
        }
        else {         
            $rowSave = array(
                "NOMECLIE"  =>  $dados->name,
                "EMAIL"     =>  $dados->email,
                "ASSUNTO"   =>  $dados->assunto,  
                "MENSAGEM"  =>  $dados->mensagem,
                "TELEFONE"  =>  $dados->phone
            );
            $sucesso = $this->ticket->saveContato($rowSave);
        }
        echo json_encode($sucesso);
        return $sucesso;
    }

    function validarCelular($telefone) {
        $telefone= trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));
        $regexTelefone = "^[0-9]{11}$^";

        //$regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular
        if (preg_match($regexTelefone, $telefone)) {
            return true;
        }else{
            return false;
        }
    }
}
?>
