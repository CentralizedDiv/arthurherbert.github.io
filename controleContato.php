<?php
include('php/seguranca.php'); // Inclui o arquivo com o sistema de segurança
protegePagina();
echo"
<html>
   <head>
      <meta charset='utf-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1'>
      <link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>
      <link rel='stylesheet' type='text/css' href='css/style.css'>
      <script src='js/jquery-1.12.1.min.js'></script>
      <script src='js/bootstrap.min.js'></script>
      <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBu5nZKbeK-WHQ70oqOWo-_4VmwOwKP9YQ'></script>
      <script src='js/jqBootstrapValidation.js'></script>
      <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
      <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
      <link rel='stylesheet' type='text/css' href='css/controleContato.css'>
      <script src='js/controleContato.js'></script>
      <title>Padaria Palmeiras</title>
   </head>
   <body>
      <div class='container-fluid text-center content'>
         <div class='row'>
            <div class = 'col-md-12'>
               <a href='index.html' class='container-action'>
               <span class='glyphicon glyphicon-arrow-left'></span>
               Voltar
               </a>
               <h1 class='controleContato'>Controle de Contato</h1>
               <ul class='nav nav-tabs nav-justified '>
                  <li id='tabFor' class='active'><a data-toggle='tab' href='#fornecedor'>Fornecedor</a></li>
                  <li id='tabTra'><a data-toggle='tab' href='#trabalheConosco'>Trabalhe Conosco</a></li>
                  <li id='tabSug'><a data-toggle='tab' href='#sugRec'>Sugestão/Reclamação</a></li>
                  <li id='tabOut'><a data-toggle='tab' href='#outros'>Outros</a></li>
               </ul>
            </div>
         </div>
         <div class='row'>
            <div class='col-md-12'>
               <div class='tab-content'>
                  <div id='fornecedor' class='tab-pane fade in active'>
                     <h2>Contato de Fornecedores</h2>
                     <div class='table-responsive'>
                        <table id='tableFornecedor' class='table table-condensed table-bordered'>
                           <thead>
                              <tr>
                                 <th width = '20%' id='DTCONTA'>Data de Recebimento</th>
                                 <th width = '40%' id='NOMECLIE'>Nome</th>
                                 <th width = '40%' id='EMAIL'>Email</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr name='row'>
                                 <td id='NOMECLIE' style='display: table-cell;'>pedro</td>
                                 <td id='ASSUNTO' style='display: none;'>FORNCEDOR</td>
                                 <td id='EMAIL' style='display: table-cell;'>pedro@gmail.com</td>
                                 <td id='NRSEQCON' style='display: none;'>000000015</td>
                                 <td id='DTCONTA' style='display: table-cell;'>2017-05-29</td>
                                 <td id='NRSEQUE' style='display: none;'>010</td>
                                 <td id='MENSAGEM' style='display: none;'>asdasd</td>
                                 <td id='CDTIPCON' style='display: none;'>1</td>
                                 <td id='TELEFONE' style='display: none;'>5464</td>
                                 <td id='DTRESPO' style='display: none;'></td>
                                 <td id='CDOPERA' style='display: none;'>0001</td>
                                 <td id='RESPOSTA' style='display: none;'></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div id='trabalheConosco' class='tab-pane fade '>
                     <h2>Contato de Possíveis Colaboradores</h2>
                     <div class='table-responsive'>
                        <table class='table table-condensed table-bordered'>
                           <thead>
                              <tr>
                                 <th width = '20%' id='DTCONTA'>Data de Recebimento</th>
                                 <th width = '40%' id='NOMECLIE'>Nome</th>
                                 <th width = '40%' id='EMAIL'>Email</th>
                              </tr>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div id='sugRec' class='tab-pane fade'>
                     <h2>Sugestões/ Reclamações</h2>
                     <div class='table-responsive'>
                        <table class='table table-condensed table-bordered'>
                           <thead>
                              <tr>
                                 <th width = '20%' id='DTCONTA'>Data de Recebimento</th>
                                 <th width = '40%' id='NOMECLIE'>Nome</th>
                                 <th width = '40%' id='EMAIL'>Email</th>
                              </tr>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div id='outros' class='tab-pane fade'>
                     <h2>Contatos Diversos</h2>
                     <div class='table-responsive'>
                        <table class='table table-condensed table-bordered'>
                           <thead>
                              <tr>
                                 <th width = '20%' id='DTCONTA'>Data de Recebimento</th>
                                 <th width = '40%' id='NOMECLIE'>Nome</th>
                                 <th width = '40%' id='EMAIL'>Email</th>
                              </tr>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id='swipe' class='closed'>
         <a class='swipe-action'>
         <span class='glyphicon glyphicon-arrow-left'></span>
         Voltar
         </a>
         <span class='glyphicon glyphicon-triangle-left swipe-pointer hidden-xs'></span>
         <div class='panel panel-swipe'>
            <div class='panel-heading'>
               <label name='NRSEQCON'>Código da Mensagem: </label>
               <label name='ASSUNTO'>Tipo de Contato: </label>
            </div>
            <div class='panel-body'>
               	<div class='container-fluid '>
        			<div class='row text-justify text-center'>
						<div class='col-md-12'>
                			<form id=' class='form-horizontal' novalidate>
                    			<div class='control-group form-group'>
                        			<div class='controls'>
               							<label name='NOMECLIE' type='input'>Nome: </label>
               						</div>
               					</div>
               					<div class='control-group form-group'>
                        			<div class='controls'>
						               <label name='EMAIL' type='input'>Email: </label>
						            </div>
						        </div>
						        <div class='control-group form-group'>
                        			<div class='controls'>
						               <label name='TELEFONE' type='input'>Telefone: </label>
						            </div>
						        </div>   
						        <div class='control-group form-group'>
                        			<div class='controls'>
						              	<label name='MENSAGEM' type='textarea'>Mensagem: </label>
						            </div>
						        </div>
						        <div class='control-group form-group'>
                        			<div class='controls'>   
						        	    <label name='RESPOSTA' type='textarea'>Resposta: </label>	
               						</div>
               					</div>	
               				</form>
               			</div>
               		</div>
               	</div>
            </div>
            <div class='panel-footer'>
               <label name='DTCONTA'>Data de Recebimento: </label>
            </div>
         </div>
      </div>
      
   </body>
</html>";