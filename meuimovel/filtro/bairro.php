?>

<?php include("Connections/painel_config.php");

$conecta = mysqli_connect($hostname_painel_config,$username_painel_config,$password_painel_config);
$db = mysqli_select_db($conecta, $database_painel_config);

$bairro = $_POST['bairro'];

$seleciona = mysqli_query($conecta, "SELECT * FROM imoveis WHERE imovelBairro = '".$bairro."' ORDER BY imovelComodos") or die(mysql_error());
echo '<option value="0">Selecione o Bairro</option>';
while($res_seleciona = mysqli_fetch_assoc($seleciona)){
	$comodos = $res_seleciona['imovelComodos'];
	echo '<option value="'.$comodos.'">'.$comodos.'</option>';
	
}?>

