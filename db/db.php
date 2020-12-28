<?php 
require_once('config.php');

try{
    $conn = new PDO("sqlsrv:Server=".MYSQL_HOST.";Database=".MYSQL_DATABASE."", MYSQL_USER, MYSQL_PASS, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}catch(PDOException $pe){
    die("Couldn't connect to database: " . $pe->getMessage());
}

if( !$conn ) {
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}
?>