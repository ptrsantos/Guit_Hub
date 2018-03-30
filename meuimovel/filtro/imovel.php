?>

<?php include("Connections/painel_config.php");
$categoria = $_POST['categoria'];
echo '<option value="0">Selecione o Bairro</option>';
$conecta = mysqli_connect($hostname_painel_config,$username_painel_config,$password_painel_config);
$db = mysqli_select_db($conecta, $database_painel_config);


$seleciona = mysqli_query($conecta, "SELECT * FROM imoveis WHERE imovelTipo = '".$categoria."' ORDER BY imovelBairro") or die(mysql_error());
//echo '<option value="">Selecione o Imóvel</option>';
while($res_seleciona = mysqli_fetch_assoc($seleciona)){
	$bairro = $res_seleciona['imovelBairro'];
	echo '<option value="'.$bairro.'">'.$bairro.'</option>';
	
}?>
