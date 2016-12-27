<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_mysqlconn = "localhost";
$database_mysqlconn = "smart_travel";
$username_mysqlconn = "root";
$password_mysqlconn = "";
$mysqlconn = mysql_pconnect($hostname_mysqlconn, $username_mysqlconn, $password_mysqlconn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>