<?php include_once("sistema/restrito_all.php");?>
<?php include_once("sistema/validar_user.php");?>
<?php include_once("header.php");?>
<div id="local">
   <div class="caminho">Onde Estou: Portal MEUIMÓVEL &raquo; Painel de Controle &raquo; Home</div><!--caminho-->
   <div class="welcome">Olá <?php echo $clienteNome;?>| Hoje <?php echo date('d/m/Y H:i').'h';?> | <a href="deslogar.php">Deslogar</a></div><!--welcome-->
</div><!--local-->
   
<div id="content">

<?php include_once("menu.php");?>     

   <div id="content_conteudo">
   
   <?php include_once("sistema/carregando.php");?>
   
   
<?php if(isset($_POST['executar']) && $_POST['executar'] == 'Informar'){
	
$imovelStatus = 'aguardando';
$imovelConfirma = strip_tags(trim($_POST['confirma']));
$imovelId = $_POST['imovelId'];

if($imovelConfirma == ''){
	echo '<div class="no">Informe o número do comprovante ou pagamento!</div>';
}else{
	
$sql_aguardando = 'UPDATE imoveis SET imovelStatus = :imovelStatus, imovelConfirma = :imovelConfirma
                   WHERE imovelId = :imovelId';

try{
	$query_aguardando = $conecta->prepare($sql_aguardando);
	$query_aguardando->bindValue(':imovelStatus',$imovelStatus,PDO::PARAM_STR);
	$query_aguardando->bindValue(':imovelConfirma',$imovelConfirma,PDO::PARAM_STR);
	$query_aguardando->bindValue(':imovelId',$imovelId,PDO::PARAM_STR);
	$query_aguardando->execute();
	
	echo '<div class="ok">Recebemos sua confirmação. assim que validada seu imóvel será anúnciado e poderá ser visto em seus imóveis ativos! por enquanto será visualizado em Aguardando aprovação!</div>';
	
	}catch(PDOexception $error_aguardando){
	  echo 'Erro ao atualizar imóvel'.$error_aguardando->getMessage();
	}
}
	
}?>     
   
   <h2>Bem vindo ao painel de anúncios do Portal MEUIMÓVEL aqui você pode criar e gerenciar seus anúncios!</h2>
   <h3>Comece a anunciar clicando em Criar Anuncio!</h3>
   <p>Todo anuncio será moderado e corrigido antes de ser aprovado! Assim que solicitado o pagamento você deve nos depositar ou efetuar o pagamento via PagSeguro de R$9,90 para ter seu      anuncio liberado! E ai então confirmar seu pagamento!</p>
   <p>Qualquer duvida fique a vontade para entrar em contato pelo e:mail email@meuimovel.com.br ou pelo FONE: 0800 0808-0808</p>
   
   <h1>CENTRAL DE PAGAMENTOS - As datas do anúncio serão de acordo com a data do pagamento. O anúncio é valido por 1 mês após liberado!</h1>
  <table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr style="background:#666; color:#FFF">
    <td align="center">Anúncio ID:</td>
    <td align="center">Titulo:</td>
    <td align="center">Cadastro em:</td>
    <td align="center">Informe o pagamento</td>
    <td align="center">Ou pague com PagSeguro</td>
  </tr>
 <?php
 
 $imovelStatus = 'processando';
 $data = date('Y-m-d H:m:s');
 $sql_pegaAtivos = 'SELECT * FROM imoveis WHERE clienteId = :clienteId 
                    AND imovelStatus = :imovelStatus AND imovelTermino >= :data
					ORDER BY imovelTermino ASC';
					
 try{
	 $query_pegaAtivos = $conecta->prepare($sql_pegaAtivos);
	 $query_pegaAtivos->bindValue(':clienteId',$clienteId,PDO::PARAM_STR);
	 $query_pegaAtivos->bindValue(':imovelStatus',$imovelStatus,PDO::PARAM_STR);
	 $query_pegaAtivos->bindValue(':data',$data,PDO::PARAM_STR);
	 $query_pegaAtivos->execute();
	 
	 $resultado_pegaAtivos = $query_pegaAtivos->fetchAll(PDO::FETCH_ASSOC);
	 
	 }catch(PDOexception $error_pegaAtivos){
        echo 'Erro ao pegar ativos';
	 }
	 
	 foreach($resultado_pegaAtivos as $resAtivos){
		 $anuncioId = $resAtivos['imovelId'];
		 $anuncioTitulo = $resAtivos['imovelTitulo'];
		 $anuncioInicio = $resAtivos['imovelCadastro'];
		 $anuncioFinal = $resAtivos['imovelTermino'];
		 $anuncioVisitas = $resAtivos['imovelVisitas'];
		 $i++;
		if($i % 2 == 0){
			$cor = 'style="background:#E6FFF2"';
		}else{
			$cor = 'style="background:#f4f4f4;"';
		}
		
		$dataHoje = mktime(0,0,0,date('m'),date('d'),date('Y'));
		$dataFim = mktime(0,0,0,date('m',strtotime($anuncioFinal)),date('d',strtotime($anuncioFinal)),                   date('Y',strtotime($anuncioFinal)));
		$executaData = $dataFim - $dataHoje;
		$faltamDias = floor($executaData/(60*60*24));
		 
		 
	 
 
 ?> 
  
  <tr <?php echo $cor;?>>
    <td align="center"><?php echo $anuncioId ;?></td>
    <td align="center"><?php echo $anuncioTitulo;?></td>
    <td align="center"><?php echo date('d/m/y',strtotime($anuncioInicio));?></td>
    <td align="center">
    <form name="aprovar" action="" enctype="multipart/form-data" method="post">
       <input type="hidden" name="imovelId" value="<?php echo $anuncioId;?>" />
       <input type="text" name="confirma"  size="40"/>
       <input type="submit" name="executar" id="executar" value="Informar" />
    
    </form>
    
    
    
    </td>
    <td align="center">
<form target="pagseguro" method="post" action="https://pagseguro.uol.com.br/checkout/checkout.jhtml">
  <input type="hidden" name="email_cobranca" value="ptrsantos@gmail.com" />
  <input type="hidden" name="tipo" value="CBR" />
  <input type="hidden" name="moeda" value="BRL" />
  <input type="hidden" name="item_id" value="<?php echo $anuncioId;?>" />
  <input type="hidden" name="item_descr" value="<?php echo $anuncioTitulo;?>" />
  <input type="hidden" name="item_quant" value="1" />
  <input type="hidden" name="item_valor" value="990" />
  <input type="hidden" name="frete" value="0" />
  <input type="hidden" name="peso" value="0" />
  <input type="image" name="submit" 
  src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamento/btnComprarBR.jpg"
  alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
    </td>
  </tr>
  
  <?php
	 }
  ?>
  
</table>
   
   <div class="no"><strong>Atenção:</strong> Após efetuar pagamento informe no campo a autenticação de seu pagamento!</div>
   
   
   <table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr style="background:#666; color:#FFF;">
    <td align="center">Pagar via depósito/tranferência:</td>
  </tr>
  <tr style="background:#f4f4f4;">
    <td align="center">
   <strong>Para ativar seu imóvel efetue o depósito de R$9,90 na seguinte conta:</strong><br />
    <strong>Agência:</strong> xxxx-xx<br />
    <strong>Conta:</strong> xxxx-xx<br />
    <strong>Banco</strong> Nome do Banco<br />
    <strong>Cliente:</strong>Paulo de Tarso R. dos Santos<br />
    <strong>Depois informe no campo acima a identificação do pagamento!</strong>
    
    </td>
  </tr>
</table>


   </div><!--conteudo-->

</div><!--contet-->
     
<?php include_once("footer.php");?>