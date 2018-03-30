<?php
/*define('HOST','localhost');
define('DB','meuimovel');
define('USER','root');
define('PASS','');*/

if(!defined("HOST")){
  define('HOST','localhost');
}
if(!defined("DB")){
  define('DB','meuimovel');
}
if(!defined("USER")){
  define('USER','root');
}
if(!defined("PASS")){
  define('PASS','');
}

$conexao = 'mysql:host='.HOST.';dbname='.DB;
try{
	$conecta = new PDO($conexao,USER,PASS);
	$conecta->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	}catch(PDOexception $error_conecta){
	  'Erro ao conectar, favor informe no email contato@upimoveis.com.br';
	}
?>