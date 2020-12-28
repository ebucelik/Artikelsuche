<?php
require_once("db/db.php");

$unEqualString = "null";
$email = $custNum = $unEqualString;

if(isset($_GET['CustNum'])){
    $custNum = $_GET['CustNum'];
}

function getEmailFromCustomer($_custNum, $_conn){
    $stmt = $_conn->prepare("SELECT TOP 1 T4.Locator as Mail
                            FROM LogisticsPostalAddress T1
                            LEFT JOIN CustTable T2 ON T2.AccountNum = '$_custNum'
                            LEFT JOIN DirPartyTable T3 ON T3.RecId = T2.Party
                            LEFT JOIN LogisticsElectronicAddress T4 ON T4.RecId = T3.PrimaryContactEmail
                            WHERE T1.Location = T3.PrimaryAddressLocation ORDER BY T1.ValidFrom DESC");
            
    $stmt->execute();

    foreach($stmt as $val){
        return $val['Mail'];
    }
}

$email = getEmailFromCustomer($custNum, $conn);

echo $email;

?>