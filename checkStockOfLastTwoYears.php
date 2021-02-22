<?php 
require_once("db/db.php");

$yearsToGoBack = 2;
$lastTwoYearsStartDate = $yearOfPhysicalDate = $itemId = "";
$today = date('Y-m-d');

if(isset($_GET["ItemId"])){
    $itemId = $_GET["ItemId"];
}

$yearOfPhysicalDate = date('Y', strtotime($today));

$lastTwoYearsStartDate = date('d.m', strtotime($today)) . '.' . ($yearOfPhysicalDate - $yearsToGoBack);

$queryFormattedDate = date('Y-m-d', strtotime($lastTwoYearsStartDate));

$stmt = $conn->prepare("SELECT TOP 1 count(T1.RecId)
                        FROM InventTrans T1
                        WHERE T1.DatePhysical >= '$queryFormattedDate' AND T1.ItemId = '$itemId'");

$stmt->execute();

$stock = $stmt->fetchColumn();

echo $stock;

   /*$stockNumber = number_format((float) $stock, 2, '.', '')

    echo $stockNumber;*/
?>