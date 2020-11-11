<?php 
require_once('config.php');

$conn = new PDO("sqlsrv:Server=".MYSQL_HOST.";Database=".MYSQL_DATABASE."", MYSQL_USER, MYSQL_PASS);

if( !$conn ) {
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}
?>