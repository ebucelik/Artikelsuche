<?php
require_once('db/db.php');

$itemId = "";

if(isset($_GET['ItemId'])){
    $itemId = $_GET['ItemId'];
}

$stmt = $conn->prepare("SELECT TOP 1 T1.DesignJpgPreviewUrl FROM MARDesignIDRelationTable T1 WHERE T1.ItemId = '$itemId'");

$stmt->execute();

foreach($stmt as $val){
    echo $val['DesignJpgPreviewUrl'];
}

?>