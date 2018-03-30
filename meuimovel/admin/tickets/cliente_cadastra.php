<?php include_once("sistema/restrito_all.php");?>
<?php include_once("sistema/validar_user.php");?>
<?php include_once("header.php");?>
<div id="local">
   <div class="caminho">Onde Estou: Portal MEUIMÓVEL &raquo; Painel de Controle &raquo; Suporte</div><!--caminho-->
   <div class="welcome">Olá <?php echo $clienteNome;?>| Hoje <?php echo date('d/m/Y H:i').'h';?> | <a href="deslogar.php">Deslogar</a></div><!--welcome-->
</div><!--local-->
   
<div id="content">

<?php include_once("menu.php");?>     

   <div id="content_conteudo">
   
<?php include_once("sistema/carregando.php");?>

<?php if(isset($_POST['executar'])){

$ticketData = date('Y-m-d H:m:d');
$ticketPergunta = strip_tags(trim($_POST['ticket']));

$sqlTicket  = 'INSERT INTO tickets (clienteId, ticketData, ticketPergunta) ';
$sqlTicket .= 'VALUES (:clienteId, :ticketData, :ticketPergunta)';
try{
	$queryTicket = $conecta->prepare($sqlTicket);
	$queryTicket->bindValue(':clienteId',$clienteId,PDO::PARAM_STR);
	$queryTicket->bindValue(':ticketData',$ticketData,PDO::PARAM_STR);
	$queryTicket->bindValue(':ticketPergunta',$ticketPergunta,PDO::PARAM_STR);
	$queryTicket->execute();
	
	echo '<div class="ok">Cadastrado, favor aguardar a resposta antes de cadastrar outro ticket!</div>';
	
	
	}catch(PDOexception $error_ticket){
	  echo 'Erro ao cadastrar o seu ticket!';	
	}
}
?>


   <form name="ticket" action="" enctype="multipart/form-data" method="post">
     <textarea rows="5" cols="125" name="ticket" class="caixa" ></textarea>
     <input type="submit" name="executar" id="executar" value="Abrir Ticket" /> 
   </form>
   
   
   <table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr style="background:#333; font:bold 12px Arial, Helvetica, sans-serif; color:#FFF;">
    <td align="center">DATA:</td>
    <td align="center">STATUS:</td>
    <td align="center">VER:</td>
  </tr>
  
<?php
$pegaTicket = 'SELECT * FROM tickets WHERE clienteId = :clienteId';
try{
	$queryPegaTicket = $conecta->prepare($pegaTicket);
	$queryPegaTicket->bindValue(':clienteId',$clienteId,PDO::PARAM_STR);
	$queryPegaTicket->execute();
	
	$res_pegaTicket = $queryPegaTicket->fetchAll(PDO::FETCH_ASSOC);
	
	}catch(PDOexception $error_pegaTicket){
	   echo 'Erro ao selecionar os tickets'.$error_ticket->getMessage();	
	}
	
	   foreach($res_pegaTicket as $resTicket){
		$ticketId = $resTicket['ticketId'];
		$ticketData = $resTicket['ticketData'];
		$ticketPergunta = $resTicket['ticketPergunta'];
		$ticketResposta = $resTicket['ticketResposta'];
		
		if($ticketResposta == ''){
		   $ticketStatus = 'Aguardando Resposta';	
		}else{
		  $ticketStatus = 'Completo';
			}
	


$i++;
if($i % 2 == 0){
  $cor = 'style="background:#E6FFF2"';
}else{
  $cor = 'style="background:#f4f4f4;"';
}


?>  
  
  <tr <?php echo $cor;?>>
    <td align="center"><?php echo date('d/m/Y H:m',strtotime($ticketData));?></td>
    <td align="center"><?php echo $ticketStatus;?></td>
    <td align="center"><a href="painel.php?exe=tickets/cliente_ver&ticket=<?php echo $ticketId;?>">Vizualizar</a></td>
  </tr>
<?php
	}
?>

</table>

   
  </div><!--conteudo-->



</div><!--contet-->
     
<?php include_once("footer.php");?>