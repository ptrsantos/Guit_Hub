<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_painel_config = "localhost";
$database_painel_config = "meuimovel";
$username_painel_config = "root";
$password_painel_config = "";
$painel_config = mysqli_connect($hostname_painel_config, $username_painel_config, $password_painel_config) or trigger_error(mysql_error(),E_USER_ERROR); 
?>