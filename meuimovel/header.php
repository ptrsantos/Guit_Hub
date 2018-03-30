<?php require_once('Connections/painel_config.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

 // $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
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

if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  //$password=md5($_POST['senha']);
  $password=($_POST['senha']);
 	//echo "Usuário = ".$loginUsername." e senha = ".$password;
  $MM_fldUserAuthorization = "usuarioNivel";
  $MM_redirectLoginSuccess = "admin/painel.php";
  $MM_redirectLoginFailed = "admin/erro.php";
  $MM_redirecttoReferrer = false;
  //mysql_select_db($database_painel_config, $painel_config);
  mysqli_select_db ($painel_config, $database_painel_config);
  	
  $LoginRS__query=sprintf("SELECT email, senha, usuarioNivel FROM clientes WHERE email=%s AND senha=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  //$LoginRS = mysql_query($LoginRS__query, $painel_config) or die(mysql_error());
  $LoginRS = mysqli_query($painel_config, $LoginRS__query) or die(mysql_error());
  $loginFoundUser = mysqli_num_rows($LoginRS);
  //echo mysqli_num_rows($LoginRS);
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
<?php include"Connections/config.php";?>
<?php include"js/scripts.php"; ?>
<?php include"funcoes.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portal MEUIMÓVEL</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="box">
  <div id="header">
  
    <div id="header_topo">
    
       <a href="index.php"><img src="images/teste.fw.png" alt="Home" title="Home" border="0"/></a>
         <ul>
           <li><a href="index.php?pg=home">Home</a></li>
           <li><a href="index.php?pg=categoria&operacao=vender">Comprar</a></li>
           <li><a href="index.php?pg=categoria&operacao=alugar">Alugar</a></li>
           <li><a href="index.php?pg=anuncie">Anúnciar</a></li>
           <li><a href="index.php?pg=contato">Fale Conosco</a></li>
         </ul>         
 
    </div><!--fecha header topo-->
    
      <div id="header_navegar">
      
        <div id="header_navegar_central">
           
           <div id="header_navegar_central_anunciante">
             <form name="central_anunciate" action="<?php echo $loginFormAction; ?>" method="POST">
                <label>
                  <span>E-mail:</span>
                  <input type="text" name="usuario" />
                </label>
                
                <label>
                 <span class="senha_txt">Senha:</span>
                 <input type="password" name="senha" class="senha" />
                 
                 <input type="submit" name="Enviar" value="" class="btn" />
                </label>
              
             </form>
             <p><a href="admin/recover.php">[Esqueci minha senha]</a></p>
           </div><!--fecha central anuncante-->

        </div><!-- fecha navegar central -->
        
          <div id="header_navegar_filtro">
          
            <h1>Encontre Seu Imóvel</h1>
            <h2>Encontre o Imóvel que você procura!</h2>
            
            <!--<form name="filtrar_avancado" method="post" action="index.php?pg=filtro">-->
            <form name="filtrar_avancado" method="post" action="index.php?pg=filtro">
               <select name="negocio" id="negocio">
                 <option value="">Comprar ou alugar?</option>
                 <option value="alugar">Alugar</option>
                 <option value="vender">Comprar</option>
               </select>
               
               <select name="categoria">
                 <option value="" disabled="disabled">Categoria do imóvel</option>
               </select>
               
               <select name="bairro">
                 <option value="" disabled="disabled">Pode selecionar o bairro!</option>
               </select>
               
               <select name="comodos">
                 <option value="" disabled="disabled">Selecione os comodos!</option>
               </select>
               
               <!--<span>Selecione um imóvel!</span>-->
               
               <input type="submit" name="listar" value="Listar Imóveis" class="btn" />
               
            
            </form>
            
          
          </div><!--fecha navegar filtro-->
          
            <div id="header_navegar_publicidade">
            <h1>Publicidade</h1>
            
              <script type="text/javascript">
              google_ad_client = "pub-6252101946778080";
              /* Página home conteúdo */
              google_ad_slot = "6369250044";
              google_ad_width = 200;
              google_ad_height = 200;
              </script>
              
              <script type="text/javascript"
              src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
              </script>
            </div><!--fecha navegar publicidade-->
      
      </div><!--fecha navegar-->
   
   </div><!--fecha o header-->