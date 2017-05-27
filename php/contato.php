<?php 
require_once("contatoTicket.php");
$ticket = new ContatoTicket();
$contato = new Contato($ticket);
//Verify if ajax pass the method and choose what parameter pass to the query
if($isset($_POST['enviar'])) {
    if(empty($_POST['name']) 
        || empty($_POST['email'])       
        || empty($_POST['assunto'])     
        || empty($_POST['mensagem'])
        || empty($_POS['phone']) 
        || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
                echo "Existem campos em branco!";
                return false;
    }
    else if(!$contato->validarCelular($_POST['phone'])) {
        echo "Numero de celular invalido";
        return false;
    }
    else {
        $rowSave = array {
            "NOMECLIE"  =>  $_POST['name'],
            "EMAIL"     =>  $_POST['email'],
            "ASSUNTO"   =>  $_POST['assunto']  
            "MENSAGEM"  =>  $_POST['mensagem']
            "TELEFONE"  =>  $_POS['phone']
        };
        $contato->saveContato($rowSave);
    }


}

else if(isset($_POST['method']) && !empty($_POST['method'])) {
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

    function saveContato($rowSave) {
        $sucesso = $this->ticket->saveContato($rowSave);
        echo json_encode($sucesso);
        return $sucesso;
    }

    function validarCelular($celular) {
        static $regex;

        if ($regex === null) {
            //Coloquei em um array para identificar melhor
            $ddds = implode('|', array(
                11, 12, 13, 14, 15, 16, 17, 18, 19,
                21, 22, 24, 27, 28,
                91, 92, 93, 94, 95,
                81, 82, 83, 84, 85, 86, 87,
                31, 32, 33, 34, 35, 37, 38,
                71, 73, 74, 75, 77, 79,
                61, 62, 63, 64, 65, 66, 67, 68, 69,
                49, 51, 53, 54, 55
            ));

            //Gera a regex
            $regex = '#^(\((' . $ddds . ')\) 9|\((?!' . $ddds . ')\d{2}\) )[6789]\d{3}-\d{4}$#';
        }

        return preg_match($regex, $celular) > 0;
    }

?>
