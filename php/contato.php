<?php
 
    require_once("contatoTicket.php");
    $ticket = new ContatoTicket();

    function getContatoFornecedor() { 
        return $ticket->getData('1');
    }

    function getContatoTrabalho() {
        return $ticket->getData('2');
    }

    function getContatoSugRe() {
        return $ticket->getData('3');
    }

    function getContatoOutros() {
        return $ticket->getData('4');
    }
}
?>