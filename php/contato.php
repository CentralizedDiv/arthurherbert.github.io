<?php
  
    if(empty($_POST['name']) 
        || empty($_POST['email']) 		
        || empty($_POST['assunto']) 	
        || empty($_POST['mensagem'])
        
        || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
            	echo "No arguments Provided!";
            	return false;
       }
    $name = $_POST['name'];
    $email_address = $_POST['email'];
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];
    //$phone = $_POST['phone'];
    	
    $headers = 'From: $email_address' . "\r\n" .
    'Reply-To: phpedromoutinho@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    	
    $to = 'phpedromoutinho@gmail.com'; 
    $email_subject = "Formulário de contato, $name te enviou uma mensagem.$assunto"; 
    $email_body = "Você recebeu uma nova mensagem do site.\n\n"."Aqui estão os detalhes:\n\nNome: $name\n\n\Assunto: $assunto\n\nEmail: $email_address\n\nMensagem:\n$mensagem";
    
    $bool = mail($to, $email_subject ,$email_body, $headers, "r".$email_address);
    var_dump($bool);die;
    return true;			
?>