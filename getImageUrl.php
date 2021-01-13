<?php
require_once('db/db.php');

$itemId = $version = $salesId = "";

if(isset($_GET['ItemId'])){
    $itemId = $_GET['ItemId'];
}

if(isset($_GET['Version'])){
    $version = $_GET['Version'];
}

if(isset($_GET['SalesId'])){
    $salesId = $_GET['SalesId'];
}

$stmt = $conn->prepare("SELECT TOP 1 T1.DesignJpgPreviewUrl FROM MARItemSearchDataTable T1 WHERE T1.ItemId = '$itemId' AND T1.InventStyleId = '$version' AND T1.SalesIdLast = '$salesId'");

$stmt->execute();

echo $stmt->fetchColumn();
?>