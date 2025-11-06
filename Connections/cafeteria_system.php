<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cafeteria_system = "localhost";
$database_cafeteria_system = "cafeteria_system";
$username_cafeteria_system = "root";
$password_cafeteria_system = "";
$cafeteria_system = mysql_pconnect($hostname_cafeteria_system, $username_cafeteria_system, $password_cafeteria_system) or trigger_error(mysql_error(),E_USER_ERROR); 
?>