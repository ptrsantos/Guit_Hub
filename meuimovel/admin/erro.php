<?php require_once('../Connections/painel_config.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  //$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
  $theValue = strip_tags(trim($theValue));

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  //$password=md5($_POST['senha']);
  $password=($_POST['senha']);
  $MM_fldUserAuthorization = "usuarioNivel";
  $MM_redirectLoginSuccess = "painel.php";
  $MM_redirectLoginFailed = "erro.php";
  $MM_redirecttoReferrer = false;
  
  //mysql_select_db($database_painel_config, $painel_config);
  mysqli_select_db($painel_config, $database_painel_config);
  	
  $LoginRS__query=sprintf("SELECT email, senha, usuarioNivel FROM clientes WHERE email=%s AND senha=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  //$LoginRS = mysql_query($LoginRS__query, $painel_config) or die(mysql_error());
  $LoginRS = mysqli_query($painel_config, $LoginRS__query) or die(mysql_error());
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    //$loginStrGroup  = mysql_result($LoginRS,0,'usuarioNivel');
	$loginStrGroup = mysqli_fetch_assoc($LoginRS);
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
	$_SESSION['MM_UserGroup'] = $loginStrGroup['usuarioNivel'];
    //$_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UpImóveis | Painel de Administração</title>
<link href="login_style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="login">
  <img src="../images/teste.fw.png"  alt="" />
  <form name="login_painel" action="<?php echo $loginFormAction; ?>" method="POST">
    <label><span>E-mail: </span><input type="text" name="email" /></label>
    <label><span>Senha: </span><input type="password" name="senha" /></label>
    <p><a href="recover.php">[ Esqueci minha senha ]</a><p>
    <input type="submit" name="logar" value="Logar" class="btn" />
  </form>

<div class="alertas_2">
<strong style="color:#F00;">[&loz;]</strong> Erro ao logar: Senha ou e-mail não conferem!
</div>


</div><!--login-->

</body>
</html>