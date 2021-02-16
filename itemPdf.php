<?php

$path = '';

if(isset($_GET['path'])){
    $path = $_GET['path'];
}

header('Content-type: application/pdf'); 
header('Content-Disposition: inline; filename="'.basename($path).'"'); 
header('Content-Transfer-Encoding: binary'); 
header('Accept-Ranges: bytes'); 

// Read the file 
@readfile($path);

?>