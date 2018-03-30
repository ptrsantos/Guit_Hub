<?php
// *** Logout the current user.
$logoutGoTo = "";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portal MEUIMÓVEL | Painel de Administração</title>
<link href="login_style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="login">
  <img src="../images/teste.fw.png"  alt="" />
  <span class="restrito">
  <strong>Deslogou com sucesso!</strong><br />
  </span>
  
  <div class="link">
   <a href="index.php">Logar</a>
   <a href="../">Voltar ao site</a>
   </div>
  

</div><!--login-->

</body>
</html>