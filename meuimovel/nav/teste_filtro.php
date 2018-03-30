
<?php /*include_once("Connections/painel_config.php");

//$conecta = mysqli_connect($hostname_painel_config,$username_painel_config,$password_painel_config);
$db = mysqli_select_db($conecta, $database_painel_config);

$cat = $_POST['categoria'];
//$cat = 'alugar';

$seleciona = mysqli_query($conecta, "SELECT * FROM imoveis WHERE imovelNegocio = '".$cat."' ORDER BY ImovelTipo") or die(mysql_error());

$res_seleciona = mysqli_fetch_assoc($seleciona);

while($res_seleciona = mysqli_fetch_assoc($seleciona)){
	$tipo = $res_seleciona['imovelTipo'];
	echo '<option value="'.$tipo.'">'.$tipo.'</option>';
	//echo '<option value="'.$res_seleciona['imovelTipo'].'">'.$res_seleciona['imovelTipo'].'</option>';
}
//var_dump($res_seleciona);
//echo $res_seleciona['imovelTipo'];

foreach($res_seleciona as $tipo){
	echo '<option value="'.$tipo.'">'.$tipo.'</option>';
}*/

//include"Connections/config.php";
include("Connections/config.php");


	//$sql = "SELECT * FROM imoveis WHERE imovelNegocio = :$cat";
	
	//$negocio = strip_tags(trim($_POST['negocio']));
	//$negocio = 'alugar';
	//echo '<option value="">'.$negocio.'</option>';
	//echo $negocio;
	//echo "Paulo";
	//echo '<option value="">'.$negocio.'</option>';
	
	$negocio = $_POST['negocio'];
	echo '<option value="">Selecione o Tipo</option>';
	//$negocio = 'alugar';
	echo '<option value="'.$negocio.'">'.$negocio.'</option>';	
	
	$sql = "SELECT * FROM imoveis WHERE imovelNegocio = :negocio ORDER BY imovelTipo";
	//echo '<option value="'.$negocio.'">'.$negocio.'</option>';
	try{
		echo '<option value="'.$negocio.'">Foi até também</option>';
		$query = $conecta->prepare($sql);
		echo '<option value="'.$negocio.'">'.$negocio.'</option>';
		$query->bindValue(':negocio',$negocio,PDO::PARAM_STR);
		$query->execute();
		//echo '<option value="'.$negocio.'">'.$negocio.'</option>';
		$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
		
		}catch(PDOexception $error_imovels){
		  echo 'Erro ao selecionar os imoves!'; 
		  //echo '<option value="">'.$negocio.'</option>';	
		}
		
		foreach($resultado as $res){
			$tipo   = $res['imovelTipo'];

         echo '<option value="'.$tipo.'">'.$tipo.'</option>';

		}
		?>

		<script>
		function() {
   		alert('veio até aqui');
		}
		</script>

